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
    if (isset($_POST["submit"])) {                        
    createCategory();
    }
    ?>
                    <div class="col-xs-6">
                        <form action="" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="cat_title">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" name="submit">Add
                                    Category</button>
                            </div>
                        </form>
                    </div>
                    <!-- table categories -->
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Category Title
                                </th>
                            </tr>
                            <?php showAllCategories(); ?>
                            <?php 
    if (isset($_GET['edit'])) {
    $the_cat_id = escape($_GET['edit']);
    $query = "SELECT * FROM categories WHERE cat_id = $the_cat_id";
    $result = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $cat_id = escape($row['cat_id']);
        $cat_title = escape($row['cat_title']);
        echo "<form method='post'>
        <div class='form-group'>
            <input type='text' class='form-control' name='cat_title' value={$cat_title}>
        </div>
        <div class='form-group'>
            <button class='btn btn-primary' type='submit' name='update'
            value='update category'>Edit Category
            </button>
        </div>
        </form>";
            }
        };
    ?>
                            <?php 
        if (isset($_GET["delete"])) {
            if (isset($_SESSION["user_role"])) {
                if ($_SESSION["user_role"] === "admin") {
                deleteCategory();
                }
            }
            };
        ?>
                            <?php 
        if (isset($_POST["update"])) {
            editCategory();
            };
        ?>
                        </table>
                    </div>

                </div>
            </main>
            <?php include './includes/footer.php'?>