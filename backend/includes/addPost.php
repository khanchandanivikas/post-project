<?php
if(isset($_POST["createPost"])) {
    createPost();
};
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title">
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
                    echo "<option value='$cat_id'>{$cat_title}</option>";
                };
                ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name="post_author">
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" class="form-control" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status">
            <option value="draft">Draft</option>
            <option value="published">Publish</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea type="text" class="form-control" name="post_content" cols="30" rows="10">
        </textarea>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit" name="createPost">Add
            Post</button>
    </div>
</form>
