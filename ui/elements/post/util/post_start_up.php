<?php
session_start();

if (isset($_GET['post_id'])) {
    $postID = $_GET['post_id'];

    include("important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM posts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postID);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    }

$comments = array(); 

if (isset($postID)) {
    $query = "SELECT * FROM comments WHERE post_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postID);
    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $comments[] = $row; 
    }
}

    $stmt->close();
    $conn->close();
}

?>