<?php
$query = "SELECT * FROM communities WHERE creator_username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $communityName = $row['name'];
    $communityDescription = $row['description'];
    $communityImage = $row['image']; 

    $membersQuery = "SELECT COUNT(*) as member_count FROM community_members WHERE community_id = ?";
    $membersStmt = $conn->prepare($membersQuery);
    $membersStmt->bind_param("s", $row['id']); 
    $membersStmt->execute();
    $membersResult = $membersStmt->get_result();
    $membersRow = $membersResult->fetch_assoc();
    $memberCount = $membersRow['member_count'];
}
?>