<?php

if (isset($_SESSION['username'])) {

    $loggedInUsername = $_SESSION['username'];


    include("../important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $posts = [];

    $batchSize = 20; 
    $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;

    $offset = ($pageNumber - 1) * $batchSize;

    $query = "SELECT p.* 
              FROM posts p
              LEFT JOIN follower f ON p.username = f.following_id AND f.follower_id = ?
              WHERE p.username = ? OR f.follower_id IS NOT NULL
              ORDER BY
                CASE
                  WHEN p.username = ? THEN 1
                  WHEN p.username IN (SELECT following_id FROM follower WHERE follower_id = ?) THEN 2
                  ELSE 3
                END,
                p.created_at DESC
              LIMIT ? OFFSET";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssii", $loggedInUsername, $loggedInUsername, $loggedInUsername, $loggedInUsername, $batchSize, $offset);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }
    $stmt->close();

    $conn->close();
}
return $posts;
?>
