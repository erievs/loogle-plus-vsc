<?php

include("important/db.php");

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

function isFollowing($conn, $followerUsername, $profileUsername) {

    $query = "SELECT * FROM followers WHERE follower_id = ? AND following_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $followerUsername, $profileUsername);
    $stmt->execute();

    $result = $stmt->get_result();

    return $result->num_rows > 0;
}

$followerUsername = $_SESSION['username'];
$profileUsername = $_GET['username']; 

$isFollowing = isFollowing($conn, $followerUsername, $profileUsername);

$conn->close();

?>

<?php
session_start();
$postDatabase = 'posts.txt';
$posts = [];

if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}

include("important/db.php");

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT username FROM user ORDER BY RAND() LIMIT 16";
$result = $conn->query($query);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row['username'];
    }
}

function getCommonFriends($conn, $user1, $user2) {
    $query = "SELECT COUNT(*) as common_count FROM followers WHERE follower_id = ? AND following_id IN (SELECT following_id FROM followers WHERE follower_id = ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $user1, $user2);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['common_count'];
}

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
    <link rel="stylesheet" href="./css/community.css">
    <link rel="stylesheet" href="./css/sidebar.css">
</head>

<body>
<header class="nav-wrapper">
    <div class="header-content">
        <a id="menu-icon" class="sidenav-trigger" style="cursor: pointer;">
            <i class="material-icons" style="vertical-align: middle; margin-bottom: 2px; color: black;">menu</i>
        </a>
        <span class="logo">&nbsp; Loogle+ &nbsp; | Communities &nbsp; </span>
        <div class="search-bar">
            <i class="material-icons prefix">search</i>
            <input type="text" placeholder="Search">
        </div>
    </div>
</header>

<div class="tabs-wrapper">
    <ul class="tabs">
        <li class="tab"><a class="active" href="./youmaylike.php">YOU MIGHT LIKE</a></li>
        <li class="tab"><a href="./member.php">MEMBER</a></li>
        <li class="tab"><a href="./yours.php">YOURS</a></li>
    </ul>
</div>

<?php include './ui-elements/sidebar.php'; ?>
</body>
</html>

<?php

$conn->close();
?>