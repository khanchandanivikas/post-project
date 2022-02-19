<?php

    $published_post_count = checkStatus('post', 'post_status', 'published');
?> 
<?php
    $draft_post_count = checkStatus('post', 'post_status', 'draft');
?>  
<?php
    $unapproved_comment_count = checkStatus('comments', 'comment_status', 'unapproved');
?>  
<?php
    $subscriber_count = checkStatus('users', 'user_role', 'subscriber');
?>  
<h1 class="mt-4">Dashboard</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
</ol>
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Post Count 
            <?php
            $post_count = recordCount('post');
            echo "<h1>$post_count</h1>"
            ?>  
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="./viewAllPosts.php">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">Comment Count 
            <?php
            $comment_count = recordCount('comments');
            echo "<h1>$comment_count</h1>"
            ?>  
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="./viewAllComments.php">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">User Count
            <?php
            $user_count = recordCount('users');
            echo "<h1>$user_count</h1>"
            ?>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="./viewAllUsers.php">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">Category Count 
            <?php
            $category_count = recordCount('categories');
            echo "<h1>$category_count</h1>"
            ?>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="./categories.php">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>
<!-- chart -->
<div class="row">
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Data', 'Count'],
                <?php
                $element_text = ["Active Posts","Published Posts", "Draft Post", "Comments", "Pending Comments", "Users", "Subscribers", "Categories"];
                $element_count = [$post_count, $published_post_count, $draft_post_count, $comment_count, $unapproved_comment_count, $user_count, $subscriber_count, $category_count];
                for ($i = 0; $i < 7; $i++) {
                    echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                }
                ?>
            ]);

            var options = {
                chart: {
                    title: '',
                    subtitle: '',
                }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
</div>