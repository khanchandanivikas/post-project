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
                                    Post Id
                                </th>
                                <th>
                                    Author
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Comment
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    In Response To
                                </th>
                                <th>
                                    Date
                                </th>
                            </tr>
                            <?php 
                             global $connection;
                             $the_post_id = escape($_GET['id']);
                             $query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection, $the_post_id)." ";
                             $result = mysqli_query($connection, $query);
                             if (!$result) {
                                 die("query failed" . mysqli_error($connection));
                             } 
                             while($row = mysqli_fetch_assoc($result)) {
                                 $comment_id = escape($row['comment_id']);
                                 $comment_post_id = escape($row['comment_post_id']);
                                 $comment_author = escape($row['comment_author']);
                                 $comment_email = escape($row['comment_email']);
                                 $comment_content = escape($row['comment_content']);
                                 $comment_status = escape($row['comment_status']);
                                 $comment_date = escape($row['comment_date']);
                                 echo "<tr>";
                                 echo "<td>
                                     {$comment_id}
                                     </td>";
                                     echo "
                                     <td>
                                     {$comment_post_id}
                                     </td>";
                                     echo "<td>
                                     {$comment_author}
                                     </td>";
                                     echo "<td>
                                     {$comment_email}
                                     </td>";
                                     echo "<td>
                                     {$comment_content}
                                     </td>";
                                     echo "<td>
                                     {$comment_status}
                                     </td>";
                         
                                     $query_post = "SELECT * FROM post WHERE post_id = $comment_post_id ";
                                     $result_post = mysqli_query($connection, $query_post);
                                     if (!$result_post) {
                                         die("query failed" . mysqli_error($connection));
                                     } 
                                     while($row = mysqli_fetch_assoc($result_post)) {
                                     $post_id = escape($row['post_id']);
                                     $post_title = escape($row['post_title']);
                                     echo "<td>
                                     <a href = '../frontend/post.php?p_id=$post_id'>{$post_title}
                                     </td>";
                                     }
                                     echo "<td>
                                     {$comment_date}
                                     </td>";
                                     echo "<td>
                                     <a href='viewAllComments.php?approve={$comment_id}'>Approve</a>
                                     <a href='viewAllComments.php?unapprove={$comment_id}'>Unapprove</a>
                                     <a href='postComments.php?delete_comment={$comment_id}&id=$the_post_id'>Delete</a>
                                     </td>";
                                     echo "</tr>";
                             }
                            ?>
                        </table>
                    </div>
                    <?php 
if (isset($_GET["delete_comment"])) {
    global $connection;
    $the_post_id = escape($_GET['id']);
    $the_comment_id = escape($_GET["delete_comment"]);
    $query = "DELETE FROM comments WHERE comment_id = $the_comment_id";
    $result = mysqli_query($connection, $query);

    $query_comment = "UPDATE post SET post_comment_count = post_comment_count - 1 ";
    $query_comment .= "WHERE post_id = $the_post_id ";
    $result = mysqli_query($connection, $query_comment);

    header("Location: postComments.php?id=$the_post_id");
    if (!$result) {
        die("delete failed" . mysqli_error($connection));
    } 
}
if (isset($_GET["approve"])) {
    approveComment();
}
if (isset($_GET["unapprove"])) {
    unApproveComment();
}
?>

                </div>
            </main>
            <?php include './includes/footer.php'?>