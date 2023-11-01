<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_SESSION['username'])) {

        $commentContent = $_POST['commentContent'];
        $postID = $_POST['postID'];


        include("important/db.php");

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        

        $query = "INSERT INTO comments (post_id, username, comment_content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $postID, $_SESSION['username'], $commentContent);

        if ($stmt->execute()) {

            header("Location: view_post.php?post_id=" . $postID); 
            exit();
        } else {

            echo "Error: " . $conn->error;
        }

        $stmt->close();
        $conn->close();
    } else {

        header("Location: user/login.php");
        exit();
    }
}
?>