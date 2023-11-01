<?php include 'ui/elements/post/util/post_start_up.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <link rel="stylesheet" href="assets/css/materialize.min.css">
    <link href="assets/css/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/p-sans.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/view_post.css">

</head>
<body>

<?php include 'ui/elements/navbar.php'; ?>

    <?php include 'ui/elements/sidebar.php'; ?>

    <div class="container">
        <br>
        <div class="row">
            <div class="col s12">
                <div class="post-container">
                    <div class="post">
                          <?php include 'ui/elements/post/post_and_comment.php'; ?>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>