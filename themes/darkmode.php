<?php
session_start();

if (isset($_GET['toggleDarkMode'])) {
    // Toggle dark mode
    $_SESSION['darkmode'] = !isset($_SESSION['darkmode']) || !$_SESSION['darkmode'];
}

if (isset($_SESSION['darkmode']) && $_SESSION['darkmode']) {
    echo '<link rel="stylesheet" href="./css/style2.css"> <!-- Link to your separated CSS file -->';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle Dark Mode</title>
</head>
<body>
    <p>
        Dark mode is currently <?php echo (isset($_SESSION['darkmode']) && $_SESSION['darkmode']) ? 'on' : 'on'; ?>.
        <a href="?toggleDarkMode">Toggle Dark Mode</a>
    </p>
</body>
</html>
