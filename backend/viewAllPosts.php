<?php include './includes/head.php'?>
<?php
if (isset($_POST["checkBoxArray"])) {
    forEach($_POST["checkBoxArray"] as $postValueId) {
    $bulk_options = $_POST['bulk_options']; 
    switch($bulk_options) {
        case 'published':
            $query = "UPDATE post SET post_status = 'published' WHERE post_id = $postValueId ";
            $result = mysqli_query($connection, $query);
            if (!$result) {
                die("query failed" . mysqli_error($connection));
            } 
        break;
        case 'draft':
            $query = "UPDATE post SET post_status = 'draft' WHERE post_id = $postValueId ";
            $result = mysqli_query($connection, $query);
            if (!$result) {
                die("query failed" . mysqli_error($connection));
            } 
        break;
        case 'delete':
            $query = "DELETE from post WHERE post_id = $postValueId ";
            $result = mysqli_query($connection, $query);
            if (!$result) {
                die("query failed" . mysqli_error($connection));
            } 
        break;
    }
    }
}
?>
<!-- <script>
    $(document).ready(function () {
        $(".delete_link").on('click', function () {
            var id = $(this).attr("rel");
            var delete_url = "viewAllPosts.php?delete=" + id + " ";
            $(".modal_delete_link").attr("href", delete_url);
            $("#myModal").modal("show");
        })
    });
</script> -->

<body class="sb-nav-fixed">

    <!-- top header -->
    <?php include './includes/nav.php'?>

    <!-- side nav bar -->
    <div id="layoutSidenav">
        <?php include './includes/sidebar.php'?>
        <!-- dashboard nav -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <?php include './includes/welcome.php'?>

                    <div class="col-xs-6">
                        <form action="" method="post">
                            <table class="table table-bordered table-hover">
                                <div id="bulkOptionsContainer" class="col-xs-4">
                                    <select class="form-control" name="bulk_options" id="">
                                        <option value="">Select Options</option>
                                        <option value="published">Publish</option>
                                        <option value="draft">Draft</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <input type="submit" name="submit" class="btn btn-success" value="Apply">
                                    <a class="btn btn-primary" href="index.php?source=add_post">Add New</a>
                                </div>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="" id="selectAllBoxes">
                                    </th>
                                    <th>
                                        Id
                                    </th>
                                    <th>
                                        Title
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Category Id
                                    </th>
                                    <th>
                                        Author
                                    </th>
                                    <th>
                                        Image
                                    </th>
                                    <th>
                                        Tags
                                    </th>
                                    <th>
                                        Content
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Comments Count
                                    </th>
                                    <th>
                                        Edit
                                    </th>
                                    <th>
                                        Delete
                                    </th>
                                    <th>
                                        View Post
                                    </th>
                                    <th>
                                        View Count
                                    </th>
                                </tr>
                                <?php showAllPosts(); ?>
                                <?php 
        if(isset($_GET["delete"])) {
            if (isset($_SESSION["user_role"]) && $_SESSION["user_role"] === "admin") {
                deletePost();
            }
        };
        ?>
                            </table>
                        </form>
                    </div>

                </div>
            </main>
            <?php include './includes/footer.php'?>