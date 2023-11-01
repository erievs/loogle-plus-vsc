<?php
session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_SESSION['username'])) {

        $username = $_SESSION['username'];

        $communityID = $_POST['community_id']; 

        $userStatus = 'member';

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
            $currentMembersCount = $communityData['members'];

            if (strpos($currentMembersList, $username) === false) {

                if (!empty($currentMembersList)) {
                    $currentMembersList .= ','; 
                }
                $currentMembersList .= $username . ':' . $userStatus;

                $newMembersCount = $currentMembersCount + 1;

                $updateQuery = "UPDATE communities SET members_list = ?, members = ? WHERE community_id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("sii", $currentMembersList, $newMembersCount, $communityID);

                if ($updateStmt->execute()) {

                    $response = ["success" => true, "message" => "Joined community successfully as a member."];
                    echo json_encode($response);
                } else {

                    $response = ["success" => false, "message" => "Error joining community."];
                    echo json_encode($response);
                }

                $updateStmt->close();
            } else {

                $response = ["success" => false, "message" => "You are already a member of this community."];
                echo json_encode($response);
            }
        } else {

            $response = ["success" => false, "message" => "Community not found."];
            echo json_encode($response);
        }

        $fetchStmt->close();
        $conn->close();
    } else {

        $response = ["success" => false, "message" => "You must be logged in to join a community."];
        echo json_encode($response);
    }
} else {

    http_response_code(418); 
    echo "Invalid request method.";
}
?>