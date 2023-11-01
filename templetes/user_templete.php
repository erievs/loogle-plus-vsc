<?php
include("ui/elements/profile/util/start_up_profile.php");
?>


<?php
include("ui/elements/profile/display_posts.php");
?>

<?php
include("ui/elements/profile/util/follow_stuff.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($_GET['username'])) { echo "" . htmlspecialchars($_GET['username']);}?> - Loogle+</title>
    <link rel="stylesheet" href="assets/css/materialize.min.css">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://egkoppel.github.io/product-sans/google-fonts.css"> 
    <link rel="stylesheet" href="assets/css/profile.css"> 
    <link rel="stylesheet" href="assets/css/profile2.css"> 
    <link rel="stylesheet" href="assets/css/style.css"> 
    <link rel="stylesheet" href="assets/css/style2_profile.css"> 
    <link rel="stylesheet" href="assets/css/yours.css"> 

    <style>
    .post,.row,header.nav-wrapper{font-family:'Product Sans','Open Sans',sans-serif}.profile-banner,.profile-banner-container{height:608px;width:1080px}.post{position:relative;padding:20px;margin-bottom:20px;border:1px solid #ccc;border-radius:5px;background-color:#fff;height:250px}.username{font-weight:700;margin-right:10px}.no-background{background-color:transparent!important}.modal-content .input-field textarea{width:100%;min-height:200px;outline:0}.input-field input[type=date],.input-field input[type=datetime-local],.input-field input[type=email],.input-field input[type=number],.input-field input[type=password],.input-field input[type=search],.input-field input[type=tel],.input-field input[type=text],.input-field input[type=time],.input-field input[type=url]{border:none;padding:0;margin:0;width:100%;background-color:transparent;-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none}.edit-profile-button{position:absolute;bottom:79px;right:-5px;z-index:2}.row{position:relative;left:-237px}header.nav-wrapper{background-color:#ffff;color:#000}#edit-profile-button,.follow-button{position:absolute;bottom:100px;right:0;z-index:2;text-align:center}.modal{will-change:top,opacity;border-radius:2px;top:28px;max-width:560px;padding:0;height:523px;display:none;position:fixed;left:0;right:0;background-color:#fafafa;max-height:70%;width:55%;margin:auto;overflow-y:auto;will-change:top,opacity}
    </style>

    <style>
    .waves-effect{position:relative;cursor:pointer;display:inline-block;overflow:hidden;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;-webkit-tap-highlight-color:transparent;vertical-align:middle;z-index:1;-webkit-transition:.3s ease-out;transition:.3s ease-out;margin-top:580px;margin-left:1260px}
    </style>

     <style>
     .community-row {
  display: flex;
  flex-wrap: wrap;
  justify-content: flex-start;
  gap: 20;
  padding: 0px;
  width: 1000px;
}

.card {
  width: 253px;
  height: 225px;
  background-color: #FFFF;
  border-radius: 0px;
  display: flex;
  flex-direction: column;
  align-items: center;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 0px;
  text-align: center;
  margin: 0 5px;
}
.community-row {
  display: flex;
  flex-wrap: wrap;
  justify-content: flex-start;
  gap: 20;
  padding: 0px;
  width: 1182px;
  left: 92px;
  position: relative;
}
.card {
  width: 247px;
  height: 270px;
  background-color: #FFFF;
  border-radius: 0px;
  display: flex;
  flex-direction: column;
  align-items: center;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 0px;
  text-align: center;
  margin: 0 5px;
}


.card-content {
    margin-right: 25px;
}

.communties {
    bottom: 27vh;
position: relative;
}

.com-title {
    left: 10%;
position: relative;
top: -28px;
}

     </style>

     <link rel="stylesheet" href="assets/css/profile_override_sep_23_23.css"> 
</head>
<body>


<?php include 'ui/elements/profile/profile_nav.php'; ?>

<?php include 'ui/elements/sidebar.php'; ?>

<?php include 'ui/elements/profile/container.php'; ?>

<script>
 document.addEventListener("DOMContentLoaded",function(){var e=document.getElementById("follow-button"),t=e.getAttribute("data-profile-username");e.addEventListener("click",function(){var n="Follow"===e.textContent.trim(),o=new XMLHttpRequest;o.open("POST","follow.php",!0),o.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),o.onreadystatechange=function(){if(4===o.readyState&&200===o.status){var t=o.responseText;"followed"===t?e.textContent="FOLLOWING":"unfollowed"===t&&(e.textContent="FOLLOW")}},o.send("isFollowing="+(n?"false":"true")+"&profileUsername="+t)})});
</script>

    <?php if (!isset($_GET['username']) || $_GET['username'] !== $_SESSION['username']) { ?>

    <?php } ?>



<?php include 'ui/elements/write_post.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
$(document).ready(function(){$("#follow-button").click(function(){var o="Follow"===$(this).text().trim(),l=$(this).data("profile-username");$.ajax({type:"POST",url:"follow.php",data:{isFollowing:o?"false":"true",profileUsername:l},success:function(o){"followed"===o?$("#follow-button").text("Unfollow"):"unfollowed"===o&&$("#follow-button").text("Follow")}})})});
</script>


<script>
document.addEventListener("DOMContentLoaded",function(){var e=document.getElementById("linkModal"),t=document.getElementById("openLinkModal"),n=document.getElementById("cancelLinkButton"),l=document.getElementById("insertLinkInput"),d=document.getElementById("insertLinkButton");M.Modal.init(document.getElementById("write-post-modal"),{});var i=M.Modal.init(e);t.addEventListener("click",()=>i.open()),n.addEventListener("click",()=>{i.close(),l.value=""}),d.addEventListener("click",()=>{document.getElementsByName("postLink")[0].value=l.value,i.close(),l.value=""})});
</script>

<script>
document.addEventListener("DOMContentLoaded",function(){var t=document.getElementById("postContent"),e=M.Modal.init(document.getElementById("write-post-modal"),{});t.addEventListener("NULL",function(){""!==t.value.trim()&&e.open()})});
</script>


<script>
document.addEventListener("DOMContentLoaded",function(){var e=!1;let t=new URLSearchParams(window.location.search);t.has("modalopen")&&"1"===t.get("modalopen")&&(e=!0);var n=M.Modal.init(document.getElementById("write-post-modal"),{});e&&n.open(),t.has("message")&&(document.getElementById("postContent").value=t.get("message"))});
</script>




</body>
</html>