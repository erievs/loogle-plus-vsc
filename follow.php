<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {

    $isFollowing = $_POST['isFollowing'] === 'true'; 
    $followerUsername = $_SESSION['username'];
    $profileUsername = $_POST['profileUsername'];

    if (empty($followerUsername) || empty($profileUsername)) {
        echo "Error: Follower or profile username is empty.";
        exit;
    }


    include("important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $query = "SELECT * FROM followers WHERE follower_id = ? AND following_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $followerUsername, $profileUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
    
        $deleteQuery = "DELETE FROM followers WHERE follower_id = ? AND following_id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("ss", $followerUsername, $profileUsername);

        if ($deleteStmt->execute()) {
            echo "unfollowed";
        } else {
            echo "Error deleting entry: " . $deleteStmt->error;
        }
    } else {

        $insertQuery = "INSERT INTO followers (follower_id, following_id) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ss", $followerUsername, $profileUsername);

        if ($insertStmt->execute()) {
            echo "followed";
        } else {
            echo "Error inserting entry: " . $insertStmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>
