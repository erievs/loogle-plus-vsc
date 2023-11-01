<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {

    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === 0) {
        $imagePath = "profiles/{$_SESSION['username']}_profile.jpg";
        move_uploaded_file($_FILES['profileImage']['tmp_name'], $imagePath);
    }

    if (isset($_POST['displayName']) && !empty($_POST['displayName'])) {

    }
}

header("Location: profile_template.php?username={$_SESSION['username']}");
?>