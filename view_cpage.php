<!-- Does stuff relating to community id and posts. -->

<?php include  'ui/elements/community/utils/community-stuff.php' ?>

<!-- Checks if you're logged in or not. -->

<?php include  'ui/elements/community/login-checker.php' ?>

<meta>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</meta>

<style>
.imgcon .dropdown-container,.imgcon .dropdown-trigger{position:absolute;top:10px;right:10px}.timestamp-right{float:right;text-align:right;font-family:'Product Sans',sans-serif;color:#b0b0b0}.post{outline:0;margin:20px 0;padding-right:0;padding-left:0;background-color:#fff;max-height:none;box-shadow:0 0 5px rgba(0,0,0,.1)}.c-name .h{width:100px;height:auto;padding-left:1%;padding-right:10px;font-size:34px;display:block;white-space:normal}.dropdown-trigger,.imgcon .dropdown-container .dropdown-trigger,.imgcon .dropdown-trigger{font-size:24px;color:#000;cursor:pointer}.dropdown-trigger{top:100px;right:10px}.imgcon{position:relative;display:inline-block}.imgcon img{width:100%;height:300px;display:block}.editCommunityModal{left:10%}
</style>

<!-- Handles the logic and other crap relating to fetching posts and other stuff -->

<?php include  'ui/elements/community/utils/posts-logic.php' ?>

<!-- Handles the logic and other crap relating to displaying posts -->

<?php include  'ui/elements/community/utils/display_posts.php' ?>

<!-- Limits the text to 25 for titles to prevent css issues. -->

<?php include  'ui/elements/community/utils/limit-text.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://egkoppel.github.io/product-sans/google-fonts.css">
<link rel="stylesheet" href="assets/css/communitypfp.css">

</head>
<!-- This breaks (for me) if done as a standalone css file, so I minified it -->
<style>
.body{background-color:#eceff1}.community-sidebar{border:none;box-shadow:none;position:fixed;left:0;height:100%;background-color:#fffF;color:#000;padding-top:20px;display:flex;flex-direction:column;justify-content:top;width:22%}.c-desc,.members{padding-left:5%;color:#9e9e9e}.c-desc{text-align:top;height:auto;font-size:20px}.search-bar{background-color:#31995f}.buttons{top:5%;position:relative;left:5%}.post-button{background-color:#d34836;color:#fff;border:none;cursor:pointer;position:absolute;bottom:20px;right:20px;-webkit-border-radius:50%;-moz-border-radius:50%;border-radius:50%;font-size:20px;padding:10px}.post-button:hover{background-color:#b83224}.row{height:100%;min-height:600px;max-height:1050px;overflow-y:auto}.imgcon .dropdown-container .dropdown-trigger{color:#fff;cursor:pointer;top:30px;right:-18px}.editCommunityModal{background-color:#fffF}.imgcon img{width:fill;height:300px;display:block}.c-desc p{margin:0}.dropdown-content{left:80px;top:-70px}.header{background-color:#ccc;height:50px;position:relative}. .custom-input-container{width:650px}.container{width:90%;position:none;top:22%;height:100%;margin-top:-55vh}.c-name{height:210px;padding-left:1%;padding-right:10px;font-size:34px;display:block;white-space:normal}@media screen and (max-width:1368px){.row{min-height:600px;max-height:450px;overflow-y:auto}h1{font-size:3.2rem}.community-sidebar{padding-top:60px}.imgcon img{width:fill;height:181px;display:block}.imgcon .dropdown-container .dropdown-trigger{color:#fff;cursor:pointer;top:33px;right:-23px}.imgcon .dropdown-container{position:absolute;top:-51px;right:10px}}
</style>
<body>

<!-- The nav bar -->

<?php include 'ui/elements/community/nav-bar-with-search_c.php'; ?>

<!-- The community button bar, aka com-btn or con-btn -->

<?php include  'ui/elements/community/community-button.php' ?>

<!-- The community side bar, it also has the posts (For some reason but it was very hard to get the css to be okay on my display so if it aint broke don't fix.) -->

<?php include  'ui/elements/community/community-sidebar.php' ?>

<!-- Tghe write post modal and crap -->

<?php include  'ui/elements/community/write-com-posts.php' ?>

<!-- The community posts crap -->

<?php include  'ui/elements/community/display_com_posts.php' ?>



<script>
document.addEventListener("DOMContentLoaded",function(){var e=M.Modal.init(document.getElementById("write-post-modal"),{}),t=document.getElementById("linkModal"),n=document.getElementById("openLinkModal"),l=document.getElementById("cancelLinkButton"),i=document.getElementById("insertLinkInput"),d=document.getElementById("insertLinkButton"),a=e.el.getAttribute("data-communityname");n.addEventListener("click",()=>{document.getElementById("communityNameInput").value=a,M.Modal.init(t).open()}),l.addEventListener("click",()=>{linkModalInstance.close(),i.value=""}),d.addEventListener("click",()=>{document.getElementsByName("postLink")[0].value=i.value,linkModalInstance.close(),i.value=""})});
</script>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded",function(){var n=document.querySelectorAll(".dropdown-trigger");M.Dropdown.init(n,{inDuration:300,outDuration:225,hover:!1,coverTrigger:!1,alignment:"left",closeOnClick:!0}),n.forEach(function(n){n.addEventListener("click",function(e){e.preventDefault(),M.Dropdown.getInstance(n).open()})})});
</script>

<script>
    // Cannot be easily minfied as it has php in it!
    document.addEventListener('DOMContentLoaded', function () {
    
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems);
   
        var joinButton = document.getElementById('joinButton');
        if (joinButton) {
            joinButton.addEventListener('click', function () {
               
                var communityID = <?php echo $communityID; ?>; 

                $.ajax({
                    url: 'join_community.php', 
                    method: 'POST',
                    data: { username: '<?php echo $_SESSION['username']; ?>', role: 'member', community_id: communityID }, 
                    success: function (response) {
                        console.log('Joined community successfully.');
                        setTimeout(() => { document.location.reload(); }, 300); 
                        joinButton.style.display = 'none';
                        var memberButton = document.createElement('a');
                        memberButton.classList.add('waves-effect', 'waves-light', 'btn');
                        memberButton.textContent = 'Member';
                        document.querySelector('.buttons').appendChild(memberButton);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error joining community:', error);
                    }
                });
            });
            
        }

        
    });

</script>

<script>
    // Cannot be easily minfied as it has php in it!
    document.addEventListener('DOMContentLoaded', function () {
        var memberButton = document.getElementById('memberButton'); 
        if (memberButton) {
            memberButton.addEventListener('click', function () {
                $.ajax({
                    url: 'leave_community.php', 
                    method: 'POST',
                    data: { username: '<?php echo $_SESSION['username']; ?>', community_id: '<?php echo $communityID; ?>' },
                    success: function (response) {            
                        console.log('Left community successfully.');
                        setTimeout(() => { document.location.reload(); }, 300); 
                        memberButton.style.display = 'none';
                        var joinButton = document.createElement('a');
                        joinButton.classList.add('waves-effect', 'waves-light', 'btn');
                        joinButton.textContent = 'Join';
                        document.querySelector('.buttons').appendChild(joinButton);
                    },
                    error: function (xhr, status, error) {                  
                        console.error('Error leaving community:', error);
                    }
                });
            });
        }
    });
</script>


<script>
    // Cannot be easily minfied as it has php in it!
    document.addEventListener('DOMContentLoaded', function () {
        var memberButton = document.getElementById('leaveButton'); 
        if (memberButton) {
            memberButton.addEventListener('click', function () {
                $.ajax({
                    url: 'leave_community.php', 
                    method: 'POST',
                    data: { username: '<?php echo $_SESSION['username']; ?>', community_id: '<?php echo $communityID; ?>' },
                    success: function (response) {
                        console.log('Left community successfully.');
                        setTimeout(() => { document.location.reload(); }, 300); 
                        memberButton.style.display = 'none';
                        var joinButton = document.createElement('a');
                        joinButton.classList.add('waves-effect', 'waves-light', 'btn');
                        joinButton.textContent = 'Join';
                        document.querySelector('.buttons').appendChild(joinButton);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error leaving community:', error);
                    }
                });
            });
        }
 });
</script>

<script>
document.addEventListener("DOMContentLoaded",function(){var t=document.getElementById("postContent"),e=M.Modal.init(document.getElementById("write-post-modal"),{});t.addEventListener("click",function(){""!==t.value.trim()&&e.open()})});
</script>

<script>
document.addEventListener("DOMContentLoaded",function(){var e=document.querySelectorAll(".sidenav");M.Sidenav.init(e)});
</script>

<script>
document.addEventListener("DOMContentLoaded",function(){M.Modal.init(document.getElementById("editCommunityModal"),{}),document.getElementById("editCommunityForm");var e=document.getElementById("saveCommunityChanges");document.getElementById("editCommunityButton").addEventListener("click",function(){document.getElementById("communityName").value="<?php echo $communityName; ?>",document.getElementById("communityDescription").value="<?php echo $communityDescription; ?>"}),e.addEventListener("click",function(){e.disabled=!0;var t=document.getElementById("communityName").value,n=document.getElementById("communityDescription").value,m=new FormData;m.append("communityName",t),m.append("communityDescription",n);var o=document.getElementById("communityImage").files[0];o&&m.append("communityImage",o),$.ajax({url:"update_community.php",method:"POST",data:m,contentType:!1,processData:!1,success:function(e){console.log("Community information updated successfully."),location.reload()},error:function(e,t,n){console.error("Error updating community information:",n)}})})});
</script>

<script>
document.addEventListener("DOMContentLoaded",function(){var e=document.querySelectorAll(".dropdown-trigger");M.Dropdown.init(e,{inDuration:300,outDuration:225,hover:!1,coverTrigger:!1,alignment:"left",closeOnClick:!0})});
</script>

<script>
document.addEventListener("DOMContentLoaded",function(){var t=document.getElementById("postContent"),e=M.Modal.init(document.getElementById("write-post-modal"),{});t.addEventListener("click",function(){e.open()})});
</script>

<script>
$(document).ready(function(){$("#saveCommunityChanges").click(function(e){e.preventDefault();var t=new FormData($("#editCommunityForm")[0]);$.ajax({type:"POST",url:"community_edit.php",data:t,cache:!1,contentType:!1,processData:!1,success:function(e){console.log(e),$("#editCommunityModal").modal("close")},error:function(e,t,n){console.error(n)}})})});
</script>

<script>
document.addEventListener("DOMContentLoaded",function(){var e=document.querySelector("h1.c-name"),t=e.offsetHeight/parseFloat(getComputedStyle(e).lineHeight);document.querySelector(".container").style.marginTop=500-(t-1)*100+"px"});
</script>


</html>
