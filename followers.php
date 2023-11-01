<?php
    include("ui/elements/people/util/followers_startup.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($_GET['username'])) { echo "" . htmlspecialchars($_GET['username']);}?> - Loogle+</title>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://egkoppel.github.io/product-sans/google-fonts.css">
    <link rel="stylesheet" href="assets/css/people.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
</head>
<body>

<?php
    include("ui/elements/people/followers_nav.php");
?>

<?php include 'ui/elements/sidebar.php'; ?>
<?php
    include("ui/elements/people/followers.php");
?>



</script>
</body>
</html>

<?php

$conn->close();
?>