<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {

    $isOwnerOrModerator = true; 

    if ($isOwnerOrModerator) {


        include("important/db.php");
        
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $communityID = $_POST['communityID'];

        $newName = $_POST['newName'];
        $newDescription = $_POST['newDescription'];

        $newImageURL = '';

        if (isset($_FILES['newImage']['name']) && !empty($_FILES['newImage']['name'])) {
            $uploadDir = 'assets/images/';
            $communityName = str_replace(' ', '_', $newName); 
            $uploadedFile = $uploadDir . $communityName . '_pic.jpg';

            if (move_uploaded_file($_FILES['newImage']['tmp_name'], $uploadedFile)) {
                $newImageURL = $uploadedFile;
            } else {

                $response = ["success" => false, "message" => "Error uploading the image."];
                echo json_encode($response);
                exit;
            }
        }

        $updateQuery = "UPDATE communities SET name = ?, description = ?, image_url = ? WHERE community_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("sssi", $newName, $newDescription, $newImageURL, $communityID);

        if ($updateStmt->execute()) {

            $response = ["success" => true, "message" => "Community information updated successfully."];
            echo json_encode($response);
        } else {

            $response = ["success" => false, "message" => "Error updating community information."];
            echo json_encode($response);
        }

        $updateStmt->close();
        $conn->close();
    } else {

        $response = ["success" => false, "message" => "You do not have permission to update this community."];
        echo json_encode($response);
    }
} else {

    http_response_code(418); 
    echo "Invalid request method.";
}
?>