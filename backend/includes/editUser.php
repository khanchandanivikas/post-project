<?php 
    if(isset($_GET["u_id"])) {
    global $connection;
    $the_user_id = $_GET['u_id'];
    $query = "SELECT * FROM users WHERE user_id = $the_user_id";
    $result = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $username = escape($row['username']);
        $user_password = escape($row['user_password']);
        $user_firstname = escape($row['user_firstname']);
        $user_lastname = escape($row['user_lastname']);
        $user_email = escape($row['user_email']);
        $user_image = escape($row['user_image']);
        $user_role = escape($row['user_role']);
    }
}
?>
<form action='' method='post' enctype='multipart/form-data'>
    <div class='form-group'>
        <label for='username'>Username</label>
        <input value="<?php echo $username ?>" type='text' class='form-control' name='username'>
    </div>
    <div class='form-group'>
        <label for='user_password'>Password</label>
        <input type='password' class='form-control' name='user_password'>
    </div>
    <div class='form-group'>
        <label for='post_tags'>First Name</label>
        <input value="<?php echo $user_firstname ?>" type='text' class='form-control' name='user_firstname'>
    </div>
    <div class='form-group'>
        <label for='user_lastname'>Last Name</label>
        <input value="<?php echo $user_lastname ?>" type='text' class='form-control' name='user_lastname'>
    </div>
    <div class='form-group'>
        <label for='user_email'>Email</label>
        <input value="<?php echo $user_email ?>" type='text' class='form-control' name='user_email'>
    </div>
    <div class='form-group'>
        <label for='user_image'>User Image</label>
        <img width="100" src="../images/<?php echo $user_image?>" alt="imagen">
        <input type='file' class='form-control' name='image'>
    </div>
    <div class='form-group'>
        <label for='user_role'>User Role</label>
        <select name="user_role">
            <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
            <?php
                if ($user_role === 'subscriber') {
                    echo "<option value='admin'>Admin</option>";
                } else {
                    echo "<option value='subscriber'>Subscriber</option>";
                }
                ?>
        </select>
    </div>
    <div class='form-group'>
        <button class='btn btn-primary' type='submit' name='editUser'>Edit
            User</button>
    </div>
</form>
<?php
    if (isset($_POST['editUser'])) {
        $username = escape($_POST['username']);
        $user_password = escape($_POST['user_password']);
        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $user_email = escape($_POST['user_email']);
        $user_image = escape($_FILES['image']['name']);
        $user_image_tmp = escape($_FILES['image']['tmp_name']);
        $user_role = escape($_POST['user_role']);
        // $hashFormat = "$2y$10$";
        // $salt = "clavesupermegasecretooo";
        // $hashF_and_salt = $hashFormat.$salt;
        move_uploaded_file($user_image_tmp, "../images/$user_image");

        if(empty($user_image)) {
            $query = "SELECT * FROM users WHERE user_id = $the_user_id ";
            $result = mysqli_query($connection, $query);
            while($row = mysqli_fetch_array($result)) {
                $user_image = $row['user_image'];
            }
        }

        if (!empty($_POST['user_password'])) {
            $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id ";
            $get_user_password = mysqli_query($connection, $query_password);
            $row = mysqli_fetch_array($get_user_password);
            $db_user_password = $row['user_password'];
            if ($db_user_password !== $user_password) {
                $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array("cost" => 10));
            }
            $query = "UPDATE users SET ";
            $query .= "username = '{$username}', ";
            $query .= "user_password = '{$hashed_password}', ";
            $query .= "user_firstname = '{$user_firstname}', ";
            $query .= "user_lastname = '{$user_lastname}', ";
            $query .= "user_email = '{$user_email}', ";
            $query .= "user_image = '{$user_image}', ";
            $query .= "user_role = '{$user_role}' ";
            $query .= "WHERE user_id = {$the_user_id} ";
            $result = mysqli_query($connection, $query);
            header("Location: viewAllUsers.php");
            if (!$result) {
               die("query failed" . mysqli_error($connection));
           } 
        } else {
            $query = "UPDATE users SET ";
            $query .= "username = '{$username}', ";
            $query .= "user_firstname = '{$user_firstname}', ";
            $query .= "user_lastname = '{$user_lastname}', ";
            $query .= "user_email = '{$user_email}', ";
            $query .= "user_image = '{$user_image}', ";
            $query .= "user_role = '{$user_role}' ";
            $query .= "WHERE user_id = {$the_user_id} ";
            $result = mysqli_query($connection, $query);
            header("Location: viewAllUsers.php");
            if (!$result) {
               die("query failed" . mysqli_error($connection));
           } 
        }
};
?>