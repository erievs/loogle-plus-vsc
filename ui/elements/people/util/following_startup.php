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

function getCommonFriends($conn, $user1, $user2) {
    $query = "SELECT COUNT(*) as common_count FROM followers WHERE follower_id = ? AND following_id IN (SELECT following_id FROM followers WHERE follower_id = ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $user1, $user2);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['common_count'];
}

function fetchLatestTextPost($conn, $username) {
    $query = "SELECT id, content
              FROM posts
              WHERE username = ? AND image_url IS NULL
              ORDER BY created_at DESC
              LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row; 
    } else {
        return false; 
    }
}

?>