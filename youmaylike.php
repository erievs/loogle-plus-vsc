<?php

include("important/db.php");

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

function isFollowing($conn, $followerUsername, $profileUsername) {

    $query = "SELECT * FROM followers WHERE follower_id = ? AND following_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $followerUsername, $profileUsername);
    $stmt->execute();

    $result = $stmt->get_result();

    return $result->num_rows > 0;
}

$followerUsername = $_SESSION['username'];
$profileUsername = $_GET['username']; 


$isFollowing = isFollowing($conn, $followerUsername, $profileUsername);



$conn->close();

?>

<?php

$username = $_SESSION['username'];

session_start();
$postDatabase = 'posts.txt';
$posts = [];

if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}


include("important/db.php");

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT username FROM user ORDER BY RAND() LIMIT 16";
$result = $conn->query($query);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row['username'];
    }
}

function getCommonFriends($conn, $user1, $user2) {
    $query = "SELECT COUNT(*) as common_count FROM followers WHERE follower_id = ? AND following_id IN (SELECT following_id FROM followers WHERE follower_id = ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $user1, $user2);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['common_count'];
}

function isUserInCommunity($conn, $username, $communityID) {
    $query = "SELECT COUNT(*) as count FROM communities WHERE community_id = ? AND members_list LIKE ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $communityID, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];

    return $count > 0;
}

?>

<?php


include("important/db.php");

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($_GET['username'])) { echo "" . htmlspecialchars($_GET['username']);}?> - Loogle+</title>
    <link rel="stylesheet" href="assets/css/materialize.min.css">
    <link href="assets/css/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/p-sans.css">
    <link rel="stylesheet" href="assets/css/yours.css">
    <link rel="stylesheet" href="assets/css/yours2.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <link rel="stylesheet" href="assets/css/youmaylike.css">
</head>


<body>

<?php include 'ui/elements/community/nav-bar-with-search_ym.php'; ?>
 



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
    $(document).ready(function () {
        $('.modal').modal();


        var openModalButton = $('#openCreateCommunityModal');

        openModalButton.click(function () {
       
            $('#createCommunityModal').modal('open');
        });

        $('#createCommunityForm').submit(function (event) {
            event.preventDefault(); 

            var communityName = $('#communityName').val();
            var communityDescription = $('#communityDescription').val();

            $.ajax({
                url: 'create_community.php', 
                method: 'POST',
                data: { name: communityName, description: communityDescription },
                success: function (response) {
                    console.log('Community created successfully.');
                    location.reload()
                },
                error: function (xhr, status, error) {
                
                    console.error('Error creating community:', error);
                }
            });

            $('#createCommunityModal').modal('close');
        });
    });
</script>


<?php include 'ui/elements/sidebar.php'; ?>

</body>
</html>


