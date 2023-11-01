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