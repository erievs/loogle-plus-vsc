<?php include 'ui/elements/people/util/following_startup.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($_GET['username'])) { echo "" . htmlspecialchars($_GET['username']);}?> - Loogle+</title>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://egkoppel.github.io/product-sans/google-fonts.css">
    <link rel="stylesheet" href="assets/css/following.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
</head>
<body>

<?php include 'ui/elements/people/following_navbar.php'; ?>

<br>
<br>
<br>

<div class="following">
<div class="row">
<div class="container">
    
<?php include 'ui/elements/people/fetch_latestes_following_posts.php'; ?>

</div>

<?php include 'ui/elements/sidebar.php'; ?>

</script>

<script>

</script>
</body>
</html>

<?php

$conn->close();
?>