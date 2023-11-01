<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo '<script>window.location.href = "user/login.php";</script>';
    exit; 
}
?>
<script type="text/javascript"> if (window.innerWidth < 1200) {window.location.href = '/mobile';}
</script>
<meta>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</meta>

<style>
.comment-icon,.horizontal-list{display:flex;display:flex}.timestamp-right{float:right;text-align:right;font-family:'Product Sans',sans-serif;color:#b0b0b0}.post{outline:0;margin:20px 0;padding-right:0;padding-left:0;background-color:#fff;max-height:none;overflow-y:auto;box-shadow:0 0 5px rgba(0,0,0,.1)}.comment-icon{justify-content:center;align-items:center;justify-content:center;align-items:center;justify-content:center;align-items:center}.comment-icon .material-icons{font-size:21px;color:#b0b0b0}.pfp2 img{margin-bottom:-7px;margin-left:18px;width:41px;height:41px}.horizontal-list{align-items:center;margin-bottom:10px}a{background-color:transparent;-webkit-text-decoration-skip:objects}.comment-icon{color:#000;background-color:#eceff1;border-radius:50%;width:34px;height:34px;justify-content:center;align-items:center;cursor:pointer;font-size:26px;float:right;top:-46px;position:relative;margin-right:10px}.comment-content{width:auto;overflow:hidden;max-width:500px}
</style>

<style>

</style>


<script>
function checkScreenWidth(){window.innerWidth<=1031&&(window.location.href="/mobile/")}window.addEventListener("load",checkScreenWidth),window.addEventListener("resize",checkScreenWidth);
</script>

<?php
include("ui/elements/home/posts_and_upload.php");
?>

<div id="postsContainer">
<?php
include("ui/elements/home/display_posts.php");
?>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google+ Clone</title>
    <link rel="stylesheet" href="assets/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="http://egkoppel.github.io/product-sans/google-fonts.css"> <!-- Link to Product Sans font -->
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Link to your separated CSS file -->
    <link rel="stylesheet" href="assets/css/style2.css"> <!-- Link to your separated CSS file -->
    <link rel="stylesheet" href="assets/css/topbar.css">
    <style>
    .custom-input-container input[type=text],input[type=text]{padding:0;margin:0;color:#b0bec5;background-color:transparent}.username a,input[type=text]{background-color:transparent}input[type=text]{border:none;border-bottom:none;box-shadow:none;outline:0;width:650px}.text-database-input{background-color:#fff;margin-top:-10px}.custom-input-container input[type=text]{border:none!important;border-bottom:none!important;box-shadow:none!important;outline:0!important;width:100%}.custom-input-container{width:650px;height:100px;padding:10px;background-color:#fff;box-shadow:none}.modal-buttons{position:fixed;bottom:10px;right:10px;z-index:1}.post{outline:0;margin:20px 0;padding-right:0;padding-left:0;background-color:#fff;max-height:none;overflow-y:auto;box-shadow:0 0 5px rgba(0,0,0,.1)}.post p{padding-right:20px;padding-left:20px}@media (max-width:null){.custom-input-container{width:350px;height:100px;padding:10px;background-color:#fff;box-shadow:none}}.comment-profile-pic,.pfp2 img{width:30px;height:30px}.horizontal-list{display:flex;align-items:center;display:flex;align-items:center;margin-bottom:0;margin-top:17px}.horizontal-list .comment-content,.horizontal-list .comment-username,.horizontal-list .pfp2{margin-right:10px}.pfp2 img{width:41px;height:41px}.username a{-webkit-text-decoration-skip:objects;color:#000}
    </style>

<link rel="stylesheet" href="assets/css/style3.css">

<?php
    if (isset($_SESSION['darkmode']) && $_SESSION['darkmode']) {
        echo '<link rel="stylesheet" href="./css/darkmode.css"> <!-- Link to your separated CSS file -->';
    }
 ?>

</head>
<body>

<?php
include("ui/elements/navbar.php");
?>

<br>

<br>

<?php include 'ui/elements/sidebar.php'; ?>


<?php
include("ui/elements/home/container.php");
?>

<?php
include("ui/elements/write_post.php");
?>



<script>
document.addEventListener("DOMContentLoaded",function(){var e=document.getElementById("linkModal"),t=document.getElementById("openLinkModal"),n=document.getElementById("cancelLinkButton"),l=document.getElementById("insertLinkInput"),d=document.getElementById("insertLinkButton");M.Modal.init(document.getElementById("write-post-modal"),{});var i=M.Modal.init(e);t.addEventListener("click",()=>i.open()),n.addEventListener("click",()=>{i.close(),l.value=""}),d.addEventListener("click",()=>{document.getElementsByName("postLink")[0].value=l.value,i.close(),l.value=""})});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded",function(){var e=document.querySelectorAll(".sidenav");M.Sidenav.init(e,{edge:"left",inDuration:250}),document.getElementById("menu-icon").addEventListener("click",function(){var n=M.Sidenav.getInstance(e[0]);n.isOpen?n.close():n.open()})});
</script>

<script>
var path=window.location.pathname,page=path.split("/").pop(),menuItems=document.querySelectorAll(".menu-item");menuItems.forEach(function(e){e.getAttribute("href")===page&&e.classList.add("active")});
</script>

<style>
.active {  background-color: #e0e0e0;  color: #333;   }
</style>



<script>
document.addEventListener("DOMContentLoaded",function(){var t=document.getElementById("postContent"),e=M.Modal.init(document.getElementById("write-post-modal"),{});t.addEventListener("input",function(){""!==t.value.trim()&&e.open()})});
</script>

</script>

<script>
document.addEventListener("DOMContentLoaded",function(){var e=document.querySelectorAll(".modal");M.Modal.init(e),document.querySelector(".post-input").addEventListener("focus",function(){M.Modal.getInstance(document.getElementById("write-post-modal")).open()})});
</script>

<script>
document.addEventListener("DOMContentLoaded",function(){var t=document.getElementById("postContent"),e=M.Modal.init(document.getElementById("write-post-modal"),{});t.addEventListener("click",function(){e.open()})});
</script>

<script>
document.addEventListener("DOMContentLoaded",function(){var e=!1;let t=new URLSearchParams(window.location.search);t.has("modalopen")&&"1"===t.get("modalopen")&&(e=!0);var n=M.Modal.init(document.getElementById("write-post-modal"),{});e&&n.open(),t.has("message")&&(document.getElementById("postContent").value=t.get("message"))});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>function refreshContent(){$.ajax({url:'ui/elements/home/display_posts.php',type:'GET',success:function(e){$('#postsContainer').html(e)},error:function(){console.error('Failed to refresh content.')}})}window.addEventListener('scroll',function(){0===window.scrollY&&refreshContent()});</script>

</body>
</html>
