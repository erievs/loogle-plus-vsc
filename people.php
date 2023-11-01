<?php
include("ui/elements/people/util/people_startup.php");
?>

<?php
session_start();
$postDatabase = 'posts.txt';
$posts = [];

if (!isset($_SESSION['username'])) {
    header("Location: user/login.php"); 
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
    <link rel="stylesheet" href="assets/css/people.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
</head>
<style>

</style>
<body>

<?php include("ui/elements/people/people_nav.php"); ?>

<?php include("ui/elements/people/freinds_suggestions.php"); ?>

<script>
document.addEventListener("DOMContentLoaded",function(){document.querySelectorAll(".follow-button").forEach(function(t){t.addEventListener("click",function(){var e="following"===t.getAttribute("data-follow-status"),o=t.getAttribute("data-profile-username"),n=new XMLHttpRequest;n.open("POST","follow.php",!0),n.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),n.onreadystatechange=function(){if(4===n.readyState&&200===n.status){var e=n.responseText;"followed"===e?(t.setAttribute("data-follow-status","following"),t.textContent="Following"):"unfollowed"===e&&(t.setAttribute("data-follow-status","not-following"),t.textContent="Follow")}},n.send("isFollowing="+!e+"&profileUsername="+o)})})});
</script>



<?php include './ui/elements/sidebar.php'; ?>

</body>
</html>

<?php
$conn->close();
?>

<script>
document.addEventListener("DOMContentLoaded",function(){var e=document.querySelectorAll(".sidenav");M.Sidenav.init(e,{edge:"left",inDuration:250}),document.getElementById("menu-icon").addEventListener("click",function(){var n=M.Sidenav.getInstance(e[0]);n.isOpen?n.close():n.open()})});
</script>