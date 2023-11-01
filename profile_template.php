<?php
session_start();

$requestedUsername = $_GET['username'];
$profileFilePath = "profiles/{$requestedUsername}.php";

if (file_exists($profileFilePath)) {

    header("Location: profile.php?username=" . urlencode($requestedUsername));
    exit; 
} else {
    echo "Profile not found.";
}
?>