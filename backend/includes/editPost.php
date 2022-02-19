<?php 
    if(isset($_GET["p_id"])) {
    global $connection;

    $the_post_id = escape($_GET['p_id']);
    $query = "SELECT * FROM post WHERE post_id = $the_post_id";
    $result = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $post_title = escape($row['post_title']);
        $post_category_id = escape($row['post_category_id']);
        $post_author = escape($row['post_author']);
        $post_img = escape($row['post_img']);
        $post_tags = escape($row['post_tags']);
        $post_content = escape($row['post_content']);
        $post_status = escape($row['post_status']);
    }
}
?>
        <form action='' method='post' enctype='multipart/form-data'>
        <div class='form-group'>
                <label for='title'>Post Title</label>
                <input value="<?php echo $post_title ?>" type='text' class='form-control' name='post_title'>
            </div>
            <div class='form-group'>
                <label for='post_category'>Post Category</label>
                <select name="post_category" id="post_category">
                <?php
                global $connection;
                $query = "SELECT * FROM categories ";
                $result = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($result)) {
                    $cat_id = escape($row['cat_id']);
                    $cat_title = escape($row['cat_title']);
                    if ($cat_id === $post_category_id) {
                        echo "<option selected value={$cat_id}>{$cat_title}</option>";
                    } else {
                        echo "<option value='$cat_id'>{$cat_title}</option>";
                    }
                };
                ?>
                </select>
            </div>
            <div class='form-group'>
                <label for='post_author'>Post Author</label>
                <input value="<?php echo $post_author ?>" type='text' class='form-control' name='post_author'>
            </div>
            <div class='form-group'>
                <label for='post_image'>Post Image</label>
                <img width="100" src="../images/<?php echo $post_img?>" alt="imagen">
                <input type='file' class='form-control' name='image'>
            </div>
            <div class='form-group'>
                <label for='post_tags'>Post Tags</label>
                <input value="<?php echo $post_tags ?>" type='text' class='form-control' name='post_tags'>
            </div>
            <div class='form-group'>
                <label for='post_status'>Post Status</label>
                <select name="post_status">
                <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
                <?php
                if ($post_status === 'draft') {
                    echo "<option value='published'>Publish</option>";
                } else {
                    echo "<option value='draft'>Draft</option>";
                }
                ?>
                </select>
            </div>
            <div class='form-group'>
                <label for="post_content">Post Content</label>
                <textarea class='form-control' name='post_content' cols='30' rows='10'>
                <?php echo $post_content ?>  
            </textarea>
            </div>
            <div class='form-group'>
                <button class='btn btn-primary' type='submit' name='editPost'>Edit
                    Post</button>
            </div>
        </form>


<?php
    if (isset($_POST['editPost'])) {
        $post_title = escape($_POST['post_title']);
        $post_category_id = escape($_POST['post_category']);
        $post_author = escape($_POST['post_author']);
        $post_img = escape($_FILES['image']['name']);
        $post_img_temp = escape($_FILES['image']['tmp_name']);
        $post_tags = escape($_POST['post_tags']);
        $post_status = escape($_POST['post_status']);
        $post_content = escape($_POST['post_content']);

        move_uploaded_file($post_img_temp, "../images/$post_img");

        if(empty($post_img)) {
            $query = "SELECT * FROM post WHERE post_id = $the_post_id ";
            $result = mysqli_query($connection, $query);
            while($row = mysqli_fetch_array($result)) {
                $post_img = $row['post_img'];
            }
        }
         $query = "UPDATE post SET ";
         $query .= "post_title = '{$post_title}', ";
         $query .= "post_category_id = '{$post_category_id}', ";
         $query .= "post_date = now(), ";
         $query .= "post_author = '{$post_author}', ";
         $query .= "post_img = '{$post_img}', ";
         $query .= "post_tags = '{$post_tags}', ";
         $query .= "post_status = '{$post_status}', ";
         $query .= "post_content = '{$post_content}' ";
         $query .= "WHERE post_id = {$the_post_id} ";
         $result = mysqli_query($connection, $query);
         header("Location: viewAllPosts.php");
         if (!$result) {
            die("query failed" . mysqli_error($connection));
        } 
};
?>
