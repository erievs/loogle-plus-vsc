<?php
session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_SESSION['username'])) {

        $username = $_POST['username'];
        $communityID = $_POST['community_id'];
        $userRole = $_POST['user_role']; 

        include("important/db.php");

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $fetchQuery = "SELECT members_list, members FROM communities WHERE community_id = ?";
        $fetchStmt = $conn->prepare($fetchQuery);
        $fetchStmt->bind_param("i", $communityID);
        $fetchStmt->execute();
        $fetchResult = $fetchStmt->get_result();

        if ($fetchResult->num_rows > 0) {
            $communityData = $fetchResult->fetch_assoc();
            $currentMembersList = $communityData['members_list'];
            $currentMemberCount = $communityData['members'];

            $entryToRemove = $username . ':' . $userRole;
            $updatedMembersList = str_replace($entryToRemove, '', $currentMembersList);
            $updatedMembersList = trim($updatedMembersList, ',');

            $updateQuery = "UPDATE communities SET members_list = ? WHERE community_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("si", $updatedMembersList, $communityID);

            $updatedMemberCount = $currentMemberCount - 1;
            $updateMemberCountQuery = "UPDATE communities SET members = ? WHERE community_id = ?";
            $updateMemberCountStmt = $conn->prepare($updateMemberCountQuery);
            $updateMemberCountStmt->bind_param("ii", $updatedMemberCount, $communityID);

            if ($updateStmt->execute() && $updateMemberCountStmt->execute()) {

                $response = ["success" => true, "message" => "Left community successfully."];
                echo json_encode($response);
            } else {

                $response = ["success" => false, "message" => "Error leaving community."];
                echo json_encode($response);
            }

            $updateStmt->close();
            $updateMemberCountStmt->close();
        } else {

            $response = ["success" => false, "message" => "Community not found."];
            echo json_encode($response);
        }

        $fetchStmt->close();
        $conn->close();
    } else {

        $response = ["success" => false, "message" => "You must be logged in to leave a community."];
        echo json_encode($response);
    }
} else {

    http_response_code(418); 
    echo "Invalid request method.";
}
?>