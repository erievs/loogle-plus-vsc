<?php

include("important/db.php");

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];

$query = "SELECT * FROM communities WHERE community_id NOT IN (
    SELECT community_id FROM communities WHERE members_list LIKE CONCAT('%', ?, '%')
)";


$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
echo '<div class="text-con1>"';
echo '<p>All Communtinties</p>';
echo '</div>';

echo '<div class="community-row">';
while ($row = $result->fetch_assoc()) {
    $communityName = $row['name'];
    $displayCommunityName = $row['display_name'];
    $communityDescription = $row['description'];
    $communityImageUrl = $row['image_url']; 

    echo '<div class="col s3">';
    echo '<a href="view_cpage.php?community_id=' . $row['community_id'] . '">';
    echo '<div class="card">';

    echo '<div class="card-image" style="height: 110px;">';
    echo '<img class="responsive-img" src="' . ($communityImageUrl ? $communityImageUrl : 'banners/deafult_com.png') . '" alt="' . $communityName . '">';
    echo '</div>';

    echo '<div class="card-content" style="display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; padding: 10px;">';

    echo '<div class="group-name-container" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 180px; margin-left: -10px;">'; // Adjust margin-left as needed
    echo '<p class="group-name" style="margin: 0;">' . $displayCommunityName . '</p>';
    echo '</div>';

    echo '</div>';

    echo '<div class="card-action" style="background: none; border: none;">';
    echo '<form action="join_community.php" method="POST">';
    echo '<input type="hidden" name="community_id" value="' . $row['community_id'] . '">';
    echo '<button class="transparent" type="submit" name="join_community">Join</button>';
    echo '</form>';
    echo '</div>';

    echo '</div>';
    echo '</div>';
}

$stmt->close();
$conn->close();
?>
