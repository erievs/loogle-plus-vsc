<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
</head>
<body>
    <?php
    session_start();
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        echo "<h2>Welcome, $username!</h2>";
        echo "<p>Your profile information and posts could be displayed here.</p>";
    } else {
        echo "<p>Please <a href='login.php'>login</a> or <a href='register.php'>register</a> to view your profile.</p>";
    }
    ?>
</body>
</html>
