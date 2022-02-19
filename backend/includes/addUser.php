<?php
if(isset($_POST["createUser"])) {
    createUser();
};
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="title">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="title">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <label for="title">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="user_image">Image</label>
        <input type="file" class="form-control" name="image">
    </div>
    <div class='form-group'>
        <label for='post_category'>Role</label>
        <select name="user_role">
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit" name="createUser">Add
            User</button>
    </div>
</form>
