<?php include './includes/head.php'?>

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
                    <?php 
if(isset($_GET["source"])) {
    $source = escape($_GET["source"]);
} else {
    $source = "";
}
    switch ($source) {
        case "add_post";
        include "./includes/addPost.php";
        break;

        case "edit_post";
        include "./includes/editPost.php";
        break;

        case "add_user";
        include "./includes/addUser.php";
        break;

        case "edit_user";
        include "./includes/editUser.php";
        break;

        default:
        include "./includes/dashboard.php";
    }
?>
                </div>
            </main>
            <?php include './includes/footer.php'?>