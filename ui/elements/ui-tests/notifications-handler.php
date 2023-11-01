<?php
session_start();

if (isset($_SESSION['username'])) {
    // Define the database configuration
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "nicknick";
    $db_name = "plus-foogle";

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve unread mentions for the current user, including post_id, sender, and formatted date
    $username = $_SESSION['username'];
    
    // Update the query to filter out mentions with read_status set to 1
    $query = "SELECT post_id, sender, content, created_at, DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') AS formatted_date 
              FROM notifications 
              WHERE recipient = ? AND read_status = 0 
              ORDER BY created_at DESC";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $mentions = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $mentions[] = $row;
        }
    }

    $stmt->close();

    echo json_encode($mentions);

    $conn->close();
}
?>
