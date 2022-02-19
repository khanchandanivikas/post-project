<?php
$connection = mysqli_connect("eu-cdbr-west-02.cleardb.net", "bd8409b2b9cdab", "a0495e69", "heroku_e635513b8596262");

// $connection = mysqli_connect("localhost", "root", "", "blog");
if (!$connection) {
    die("connection failed");
} 

function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function showAllCategories () {
    global $connection;
    $query = "SELECT * FROM categories ";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
    while($row = mysqli_fetch_assoc($result)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "
            <tr>
                <td>
                {$cat_id}
                </td>
                <td>
                {$cat_title}
                </td>
                <td>
                <a class='btn btn-info' href='categories.php?edit={$cat_id}'>Edit</a>
                <a class='btn btn-danger' href='categories.php?delete={$cat_id}'>Delete</a>
                </td>
            </tr>";
    }
};

function createCategory () {
    global $connection;
    $cat_title = escape($_POST["cat_title"]);
    if ($cat_title == '' || empty($cat_title)) {
        echo "This field should not be empty";
        } else {
            $query = "INSERT INTO categories (cat_title) ";
            $query .= "VALUES ('$cat_title') ";
            $result = mysqli_query($connection, $query);
            if (!$result) {
                die("insertion failed" . mysqli_error($connection));
            } 
        }
};

function deleteCategory () {
    global $connection;
    $the_cat_id = escape($_GET["delete"]);
    $query = "DELETE FROM categories WHERE cat_id = $the_cat_id";
    $result = mysqli_query($connection, $query);
    header("Location: categories.php");
    if (!$result) {
        die("delete failed" . mysqli_error($connection));
    } 
};

function editCategory () {
    global $connection;
    if (isset($_GET['edit'])) {
        $the_cat_id = escape($_GET['edit']);
        $query = "SELECT * FROM categories WHERE cat_id = $the_cat_id";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $cat_id = escape($row['cat_id']);
        }
    }
    $the_cat_title = escape($_POST["cat_title"]);
    $query = "UPDATE categories SET cat_title = '{$the_cat_title}' WHERE cat_id = {$cat_id} ";
    $result = mysqli_query($connection, $query);
    header("Location: categories.php");
    if (!$result) {
        die("delete failed" . mysqli_error($connection));
    } 
};

function showAllPosts () {
    global $connection;
    // $query = "SELECT * FROM post ORDER BY post_id DESC";
    $query = "SELECT post.post_id, post.post_category_id, post.post_title, post.post_author, post.post_date, post.post_img, post.post_content, post.post_tags, post.post_comment_count, post.post_status, post.post_views, ";
    $query.= "categories.cat_id, categories.cat_title ";
    $query.= "FROM post ";
    $query.= "LEFT JOIN categories ON post.post_category_id = categories.cat_id ORDER BY post.post_id DESC ";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
    while($row = mysqli_fetch_assoc($result)) {
        $post_id = escape($row['post_id']);
        $post_category_id = escape($row['post_category_id']);
        $post_title = escape($row['post_title']);
        $post_author = escape($row['post_author']);
        $post_date = escape($row['post_date']);
        $post_img = escape($row['post_img']);
        $post_content = substr($row['post_content'], 0, 100);
        $post_tags = escape($row['post_tags']);
        $post_comment_count = escape($row['post_comment_count']);
        $post_status = escape($row['post_status']);
        $post_views = escape($row['post_views']);
        $cat_title = escape($row['cat_title']);
        echo "<tr>";
        echo "<td>
            <input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='$post_id'>
            </td>";
        echo "<td>
            {$post_id}
            </td>";
            echo "
            <td>
            {$post_title}
            </td>";
            echo "<td>
            {$post_date}
            </td>";

            // $query_cat = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
            // $result_cat = mysqli_query($connection, $query_cat);
            // while($row = mysqli_fetch_assoc($result_cat)) {
            //     $cat_title = escape($row['cat_title']);
            // };

            echo "<td>
            {$cat_title}
            </td>";
            echo "<td>
            {$post_author}
            </td>";
            echo "<td>
            <img width=100 src='../images/{$post_img}'>
            </td>";
            echo "<td>
            {$post_tags}
            </td>";
            echo "<td>
            {$post_content}
            </td>";
            echo "<td>
            {$post_status}
            </td>";
            echo "<td>
            <a href='postComments.php?id=$post_id'>{$post_comment_count}</a> 
            </td>";
            echo "<td>
            <a class='btn btn-info' href='index.php?source=edit_post&p_id={$post_id}'>Edit</a>
            </td>";
            echo "<td>
            <a class='btn btn-danger' href='viewAllPosts.php?delete={$post_id}'>Delete</a>
            </td>";
            echo "<td>
            <a href='../frontend/post.php?p_id={$post_id}'>View Post</a>
            </td>";
            echo "<td>
            {$post_views}
            </td>";
            echo "</tr>";
}
};
// <a rel='{$post_id}' href='javascript:void(0)' class='delete_link' data-toggle='modal' data-target='#myModal'>Delete</a>
function createPost () {
    global $connection;
    $post_category_id = escape($_POST['post_category']);
    $post_title = escape($_POST['post_title']);
    $post_author = escape($_POST['post_author']);
    $post_date = date('d-m-y');
    $post_img = escape($_FILES['image']['name']);
    $post_img_temp = escape($_FILES['image']['tmp_name']);
    $post_content = escape($_POST['post_content']);
    $post_tags = escape($_POST['post_tags']);
    $post_status = escape($_POST['post_status']);

    move_uploaded_file($post_img_temp, "../images/$post_img");

    $query = "INSERT INTO post (post_category_id, post_title, post_author, post_date, post_img, post_content, post_tags, post_status, post_views) ";
    $query .= "VALUES ($post_category_id, '$post_title', '$post_author', now(), '$post_img', '$post_content', '$post_tags', '$post_status', 0) ";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("insertion failed" . mysqli_error($connection));
    } 
    echo "<p class='bg-success'>Post Created: "." "."<a href='viewAllPosts.php'>View Posts</a></p>";
};

function deletePost () {
    global $connection;
    $the_post_id = escape($_GET["delete"]);
    $query = "DELETE FROM post WHERE post_id = $the_post_id";
    $result = mysqli_query($connection, $query);
    header("Location: viewAllPosts.php");
    if (!$result) {
        die("delete failed" . mysqli_error($connection));
    } 
};

function approveComment () {
    global $connection;
    $the_comment_id = escape($_GET["approve"]);
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_comment_id ";
    $result = mysqli_query($connection, $query);
    header("Location: viewAllComments.php");
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
}

function unApproveComment () {
    global $connection;
    $the_comment_id = escape($_GET["unapprove"]);
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id ";
    $result = mysqli_query($connection, $query);
    header("Location: viewAllComments.php");
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
}

function showAllUsers () {
    global $connection;
    $query = "SELECT * FROM users ";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
    while($row = mysqli_fetch_assoc($result)) {
        $user_id = escape($row['user_id']);
        $username = escape($row['username']);
        $user_firstname = escape($row['user_firstname']);
        $user_lastname = escape($row['user_lastname']);
        $user_email = escape($row['user_email']);
        $user_image = escape($row['user_image']);
        $user_role = escape($row['user_role']);

        echo "<tr>";
        echo "<td>
            {$user_id}
            </td>";
            echo "
            <td>
            {$username}
            </td>";
            echo "<td>
            {$user_firstname}
            </td>";
            echo "<td>
            {$user_lastname}
            </td>";
            echo "<td>
            {$user_email}
            </td>";
            echo "<td>
            <img width=100 src='../images/{$user_image}'>
            </td>";
            echo "<td>
            {$user_role}
            </td>";
            echo "<td>
            <a href='viewAllUsers.php?change_to_admin={$user_id}'>Admin</a>
            <a href='viewAllUsers.php?change_to_subscriber={$user_id}'>Subscriber</a>
            </td>";
            echo "<td>
            <a class='btn btn-info' href='index.php?source=edit_user&u_id={$user_id}'>Edit</a>
            </td>";
            echo "<td>
            <a class='btn btn-danger' href='viewAllUsers.php?delete_user={$user_id}'>Delete</a>
            </td>";
            echo "</tr>";
}
};

function createUser () {
    global $connection;
    $username = escape($_POST['username']);
    $user_password = escape($_POST['user_password']);
    $user_firstname = escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);
    $user_email = escape($_POST['user_email']);
    $user_image = escape($_FILES['image']['name']);
    $user_image_tmp = escape($_FILES['image']['tmp_name']);
    $user_role = escape($_POST['user_role']);

    move_uploaded_file($user_image_tmp, "../images/$user_image");

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array("cost" => 10));

    $query = "INSERT INTO users (username, user_password, user_firstname, user_lastname, user_email, user_image, user_role) ";
    $query .= "VALUES ('$username', '$user_password', '$user_firstname', '$user_lastname', '$user_email', '$user_image', '$user_role') ";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("insertion failed" . mysqli_error($connection));
    } 
    echo "<p class='bg-success'>User Created: "." "."<a href='viewAllUsers.php'>View Users</a></p>";
};

function deleteUser () {
    global $connection;
    $the_user_id = mysqli_real_escape_string($connection, escape($_GET["delete_user"])) ;
    $query = "DELETE FROM users WHERE user_id = $the_user_id ";
    $result = mysqli_query($connection, $query);
    header("Location: viewAllUsers.php");
    if (!$result) {
        die("delete failed" . mysqli_error($connection));
    } 
};

function changeToAdmin () {
    global $connection;
    $the_user_id = escape($_GET["change_to_admin"]);
    $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $the_user_id ";
    $result = mysqli_query($connection, $query);
    header("Location: viewAllUsers.php");
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
}

function changeToSubscriber () {
    global $connection;
    $the_user_id = escape($_GET["change_to_subscriber"]);
    $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $the_user_id ";
    $result = mysqli_query($connection, $query);
    header("Location: viewAllUsers.php");
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
}

function usersOnline () {
global $connection;
$session = session_id();
$time = time();
$time_out_in_secs = 60;
$time_out = $time - $time_out_in_secs;
$query = "SELECT * FROM users_online WHERE session = '$session' ";
$result = mysqli_query($connection, $query);
if (!$result) {
    die("query failed" . mysqli_error($connection));
} 
$count = mysqli_num_rows($result);
// if new user logs in
if ($count == NULL) {
    mysqli_query($connection, "INSERT INTO users_online (session, time) VALUES ('$session', '$time') ");
// id users is already online
} else {
    mysqli_query($connection, "UPDATE users_online SET time = $time WHERE session = '$session' ");
}
// user longer than 30 secs
    $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");
    return $count_users = mysqli_num_rows($users_online_query);
}

function recordCount ($table) {
    global $connection;
    $query = "SELECT * FROM " . $table;
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
    $count = mysqli_num_rows($result);
    return $count;
}

function checkStatus ($table, $column, $status) {
    global $connection;
    $query = "SELECT * FROM $table WHERE $column = '$status' ";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
    return $count = mysqli_num_rows($result);
}

// not currently being used
function isAdmin ($username) {
    global $connection;
    $query = "SELECT user_role FROM users WHERE username = '$username' ";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("query failed" . mysqli_error($connection));
    } 
    $row = mysqli_fetch_array($result);
    if ($row['user_role'] === 'admin') {
        return true;
    } else {
        return false;
    };
}

?>