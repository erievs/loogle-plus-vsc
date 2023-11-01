<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {
    if (isset($_POST['postContent']) && !empty($_POST['postContent'])) {

        include("important/db.php");

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $username = $_SESSION['username'];
        $postContent = $_POST['postContent'];
        $postImageURL = ''; 
        $imageLinkURL = isset($_POST['imageLink']) ? $_POST['imageLink'] : ''; 
        $postLinkURL = isset($_POST['postLink']) ? $_POST['postLink'] : ''; 

        if ($_FILES['postImage']['error'] === 0) {
            $uploadDir = 'assets/images/';
            $uploadedFile = $uploadDir . basename($_FILES['postImage']['name']);
            move_uploaded_file($_FILES['postImage']['tmp_name'], $uploadedFile);
            $postImageURL = $uploadedFile;
        }

        $query = "INSERT INTO posts (username, content, image_url, image_link, post_link, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $username, $postContent, $postImageURL, $imageLinkURL, $postLinkURL);
        $stmt->execute();

        $stmt->close();
        $conn->close();

    }
}

$posts = [];

if (isset($_SESSION['username'])) {

    include("important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $profileUsername = $_GET['username']; 
    $query = "SELECT * FROM posts WHERE username = ? ORDER BY created_at DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $profileUsername);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }

    $stmt->close();
    $conn->close();
}
?>