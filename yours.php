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


?>

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($_GET['username'])) { echo "" . htmlspecialchars($_GET['username']);}?> - Loogle+</title>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://egkoppel.github.io/product-sans/google-fonts.css">
    <link rel="stylesheet" href="assets/css/yours.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
</head>

<style>
.sidebar{top:-10%}.community{justify-content:flex-start;margin-right:auto}.transparent{background-color:transparent!important;color:inherit!important;border:none!important;box-shadow:none!important;text-decoration:none!important;cursor:pointer;font-size:15px;font-weight:600}.card-action,.sidenav li a[href="youmaylike.php"],.sidenav li>a>i.material-symbols-outlined{color:#2fac6f}.card-content,.card-title{align-content:left;font-size:16px;text-align:left}.community-button{height:100px;width:100px}.modal .modal-footer{padding-top:15%}.mat-icon{padding-top:20%;font-family:\'Product Sans\',sans-serif;cursor:pointer;top:-10%}.mat-icon p{color:#9e9e9e}.card-image{width:100%;height:fill;overflow:hidden}.card-image img.responsive-img{width:100%;height:auto}.card-content .p{position:fixed;text-align:left}.group-name{white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin:0}.modal{height:40%}.nav-wrapper,.tabs{background-color:#009d56}.search-bar{background-color:#2fac6f;border-radius:2px}input:not([type]):focus:not([readonly]),input[type=date]:not(.browser-default):focus:not([readonly]),input[type=datetime-local]:not(.browser-default):focus:not([readonly]),input[type=datetime]:not(.browser-default):focus:not([readonly]),input[type=email]:not(.browser-default):focus:not([readonly]),input[type=number]:not(.browser-default):focus:not([readonly]),input[type=password]:not(.browser-default):focus:not([readonly]),input[type=search]:not(.browser-default):focus:not([readonly]),input[type=tel]:not(.browser-default):focus:not([readonly]),input[type=text]:not(.browser-default):focus:not([readonly]),input[type=time]:not(.browser-default):focus:not([readonly]),input[type=url]:not(.browser-default):focus:not([readonly]),textarea.materialize-textarea:focus:not([readonly]){border-bottom:0!important;-webkit-box-shadow:none!important;box-shadow:none!important}.search-bar input[placeholder=Search]{padding-top:11px}.tabs .tab a .active{content:"RECOMMENDED"}.card-action{right:77px;top:12px}.tabs .tab a,.tabs .tab a:hover{color:#ffffffbd}.tabs .tab a .active,.tabs .tab a.active:hover,i.material-icons[style="vertical-align: middle; margin-bottom: 2px; color: black;"]{color:#fff!important}.tabs .tab a:focus,.tabs .tab a:focus.active{background-color:rgba(0,0,0,0)}
</style>

<body>

<!-- The header for this -->

<?php include 'ui/elements/community/nav-bar-with-search_y.php'; ?>

<!-- The lazy no css way -->

<br><br><br>



<!-- The modal for creating communties -->

<?php include 'ui/elements/community/create-community-modal.php'; ?>

<!-- Displays the community suggests and also the create community -->

<?php include 'ui/elements/community/yours-displaying.php'; ?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
$(document).ready(function(){$(".modal").modal(),$("#openCreateCommunityModal").click(function(){$("#createCommunityModal").modal("open")}),$("#createCommunityForm").submit(function(o){o.preventDefault();var e=$("#communityName").val(),t=$("#communityDescription").val();$.ajax({url:"create_community.php",method:"POST",data:{name:e,description:t},success:function(o){console.log("Community created successfully."),location.reload()},error:function(o,e,t){console.error("Error creating community:",t)}}),$("#createCommunityModal").modal("close")})});
</script>

<script>

document.addEventListener("DOMContentLoaded",function(){let t=document.getElementById("communityName"),e=document.getElementById("communityDescription");t.addEventListener("input",function(t){let e=t.target.value;/^[A-Za-z0-9_]+$/.test(e)&&/[A-Za-z]/.test(e)&&!(e.length>30)?t.target.setCustomValidity(""):t.target.setCustomValidity("Invalid input. Only letters, numbers, and underscores are allowed, spaces are not allowed due to tables, and it should be 30 characters or fewer.")}),e.addEventListener("input",function(t){let e=t.target.value;e.length>188?t.target.setCustomValidity("Description should be 100 characters or fewer."):t.target.setCustomValidity("")})});
</script>

<script>
document.addEventListener("DOMContentLoaded",function(){let e=document.getElementById("communityName");e.addEventListener("input",function(e){let t=e.target.value,n=t.split(" "),a=n.map(e=>e.slice(0,11)),i=a.join(" ");e.target.value=i})});
</script>

<?php include 'ui/elements/sidebar.php'; ?>


</body>
</html>


