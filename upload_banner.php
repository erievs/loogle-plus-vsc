<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $targetDir = 'banners/';
    $targetFile = $targetDir . $username . '_banner.png';
    $imageFileType = strtolower(pathinfo($_FILES['bannerImage']['name'], PATHINFO_EXTENSION));
    $uploadOk = 1;

    $check = getimagesize($_FILES['bannerImage']['tmp_name']);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    if (file_exists($targetFile)) {
        unlink($targetFile);
    }

    if ($imageFileType != "png") {
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["bannerImage"]["tmp_name"], $targetFile)) {
            header("Location: profile.php?username=$username");
            exit;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>