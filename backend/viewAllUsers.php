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

                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Username
                                </th>
                                <th>
                                    First Name
                                </th>
                                <th>
                                    Last Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Image
                                </th>
                                <th>
                                    Role
                                </th>
                                <th>
                                    Role Edit
                                </th>
                                <th>
                                    Edit
                                </th>
                                <th>
                                    Delete
                                </th>
                            </tr>
                            <?php showAllUsers(); ?>
                            <?php 
        if(isset($_GET["delete_user"])) {
            if (isset($_SESSION["user_role"])) {
                if ($_SESSION["user_role"] === "admin") {
                    deleteUser();
                }
            }
        };
        if (isset($_GET["change_to_admin"])) {
            changeToAdmin();
        }
        if (isset($_GET["change_to_subscriber"])) {
            changeToSubscriber();
        }
        ?>
                        </table>
                    </div>

                </div>
            </main>
            <?php include './includes/footer.php'?>