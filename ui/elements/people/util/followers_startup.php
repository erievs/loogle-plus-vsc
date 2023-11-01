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

$query = "SELECT u.username
          FROM user AS u
          INNER JOIN followers AS f ON u.username = f.follower_id
          WHERE f.following_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row['username'];
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