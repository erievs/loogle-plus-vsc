
<?php
session_start(); 

if (isset($_GET['community_id'])) {

    $communityID = $_GET['community_id'];

    include("important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM communities WHERE community_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $communityID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $communityData = $result->fetch_assoc();
        $communityName = $communityData['name'];
        $displaycommunityName  = $communityData['display_name'];
        $communityDescription = $communityData['description'];
        $memberCount = $communityData['members'];
        $membersList = $communityData['members_list'];
        $imageURL = $communityData['image_url'];
    } else {
        echo "Community not found.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Community ID not provided.";
}
?>
