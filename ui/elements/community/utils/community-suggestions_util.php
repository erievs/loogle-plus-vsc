
<?php

include("important/db.php");

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];

$query = "SELECT * FROM communities WHERE members_list LIKE ?";
$stmt = $conn->prepare($query);
$searchUsername = "%" . $username . "%"; 
$stmt->bind_param("s", $searchUsername);
$stmt->execute();
$result = $stmt->get_result();

echo '<div class="text-con1>"';
echo '<p>All Communtinties</p>';
echo '</div>';

echo '<div class="community-row">';

while ($row = $result->fetch_assoc()) {
    $communityName = $row['name'];
    $displaycommunityName = $row['display_name'];
    $communityDescription = $row['description'];
    $communityImageUrl = $row['image_url']; 
    $membersCount = $row['members']; 
    $communityID = $row['community_id'];

    echo '<div class="col s3">';
    echo '<a href="view_cpage.php?community_id=' . $communityID . '">';
    echo '<div class="card">';

    echo '<div class="card-image" style="height: 110px;">';
    echo '<img class="responsive-img" src="' . ($communityImageUrl ? $communityImageUrl : 'banners/deafult_com.png') . '" alt="' . $communityName . '">';
    echo '</div>';
    echo '<div class="card-content" style="display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; padding: 10px;">';

    echo '<div class="group-name-container" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 180px; margin-left: -10px;">'; 
    echo '<p class="group-name" style="margin: 0;">' . $displaycommunityName . '</p>';
    echo '</div>';

    echo '<div class="members-count-container" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 0; color: #9e9e9e; font-family: \'Product Sans\', sans-serif; margin-left: -10px;">'; 
    echo '<p class="members-count" style="margin: 0;">' . ($membersCount === 1 ? '1 Member' : $membersCount . ' Members') . '</p>';
    echo '</div>';
    echo '</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    $communityCount++;

}

$stmt->close();
$conn->close();
?>