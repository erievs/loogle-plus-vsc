<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {

    if (isset($_POST['communityID'], $_POST['communityDisplayName'], $_POST['communityName']) && !empty($_POST['communityName'])) {

        $communityID = intval($_POST['communityID']);
        $newCommunityDisplayName = $_POST['communityDisplayName'];
        $newCommunityName = $_POST['communityName'];
        $newCommunityDescription = $_POST['communityDescription'];

        $newCommunityImageURL = '';

        if ($_FILES["communityImage"]["error"] === 0) {
            $uploadDir = "images/";
            $randomFilename = uniqid() . "_" . basename($_FILES["communityImage"]["name"]);
            $uploadedFile = $uploadDir . $randomFilename;
            if (move_uploaded_file($_FILES["communityImage"]["tmp_name"], $uploadedFile)) {
                $newCommunityImageURL = $uploadedFile;
            }
        }

        include("important/db.php");

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "UPDATE communities SET display_name = ?, name = ?, description = ?, image_url = ? WHERE community_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $newCommunityDisplayName, $newCommunityName, $newCommunityDescription, $newCommunityImageURL, $communityID);

        if ($stmt->execute()) {

            $stmt->close();
            $conn->close();

            header("Location: view_cpage.php?community_id=$communityID");
            exit;
        } else {
            echo "Error updating community information: " . $stmt->error;
        }
    } else {
        echo "Invalid or missing community data.";
    }
} else {
    echo "Invalid request or not logged in.";
}
?>