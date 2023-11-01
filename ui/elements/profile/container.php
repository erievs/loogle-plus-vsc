<div class="container">


<div class="profile-banner-container">
    
    <img class="profile-banner" src="<?php echo file_exists($bannerPath) ? $bannerPath : 'banners/default.jpg'; ?>" alt="Profile Banner" style="width: 1084px;
height: 364.1px;
left: 6%;
margin-left: auto;
margin-right: auto;">


    <?php if (isset($_SESSION['username'])) { $loggedInUsername = $_SESSION['username'];  $profileUsername = $_GET['username'];if ($profileUsername === $loggedInUsername) {?>

        <div class="profile-info">
       <p><?php if (isset($_GET['username'])) { echo "" . htmlspecialchars($_GET['username'] . ""); } ?></p>
       <div class ="typeuser">
       <h6>Placeholder</h6>
     </div>
       </div>

            <button id="edit-profile-button" class="edit-profile-button"><p>EDIT PROFILE</p></button>

            <div id="edit-profile-modal" class="edit-profile-modal">

    


            
                <div class="edit-profile-content">
                    <span class="close-button">&times;</span>
                        <p><?php if (isset($_GET['username'])) { echo "" . htmlspecialchars($_GET['username'] . "'s Posts"); } ?></p>
                    <h4>Edit Profile</h4>
                    <form action="profile_edit.php" method="post" enctype="multipart/form-data">
                        <label for="profile-image">Profile Image:</label>
                        <input type="file" name="profileImage" accept="image/png,image/jpeg,image/jpg,video/gif">
                        <label for="display-name">Display Name:</label>
                        <input type="text" name="displayName" value="<?php echo $_SESSION['username']; ?>">
                        <button type="submit" class="save-button">Save</button>
                    </form>
                </div>
            </div>
            

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var editProfileButton = document.getElementById('edit-profile-button');
                    var editProfileModal = document.getElementById('edit-profile-modal');
                    var closeButton = editProfileModal.querySelector('.close-button');
                    editProfileButton.addEventListener('click', function() {
                        editProfileModal.style.display = 'block';
                    });
                    closeButton.addEventListener('click', function() {
                        editProfileModal.style.display = 'none';
                    });
                    window.addEventListener('click', function(event) {
                        if (event.target === editProfileModal) {
                            editProfileModal.style.display = 'none';
                        }
                    });
                });
            </script>

            <?php
        } else {

            if ($isFollowing) {

                ?>
              <button id="follow-button" class="btn waves-effect waves-light" data-profile-username="<?php if (isset($_GET['username'])) { echo htmlspecialchars($_GET['username']); } ?>">Following</button>
                <script>

                    var followButton = document.getElementById('follow-button');
                    followButton.addEventListener('click', function() {

                    });
                </script>
                <?php
            } else {

                ?>
             <button id="follow-button" class="btn waves-effect waves-light" data-profile-username="<?php if (isset($_GET['username'])) { echo htmlspecialchars($_GET['username']); } ?>">Follow</button>

                <?php
            }
        }
    } else {

    }
    ?>

    
</div>

<div class="communties">
<div class="com-title">
<h6><?php if (isset($_GET['username'])) { echo "" . htmlspecialchars($_GET['username'] . "'s Intrests"); } ?></h6>
</div>
<?php
function displayCommunitiesForProfile($profileUsername) {
    include("important/db.php");
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM communities WHERE creator_username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $profileUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    $communityCount = 0; // Initialize the community count

    echo '<div class="community-row">';
    
    while ($row = $result->fetch_assoc()) {
        if ($communityCount >= 4) {
            break; // Limit to 4 communities
        }

        $communityName = $row['name'];
        $displayCommunityName = $row['display_name'];
        $communityDescription = $row['description'];
        $communityImageUrl = $row['image_url']; 
        $membersCount = $row['members']; 
        $communityID = $row['community_id'];
        $username = $_GET['username'];

        echo '<div class="col s3">';
        echo '<a href="view_cpage.php?community_id=' . $communityID . '">';
        echo '<div class="card">';
        
        echo '<div class="card-image" style="height: 110px;">';
        echo '<img class="responsive-img" src="' . ($communityImageUrl ? $communityImageUrl : 'banners/deafult_com.png') . '" alt="' . $communityName . '">';
        echo '</div>';
        echo '<div class="card-content" style="display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; padding: 10px;">';
        
        echo '<div class="group-name-container" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 180px; margin-left: -10px;">';
        echo '<p class="group-name" style="margin: 0;">' . $displayCommunityName . '</p>';
        echo '</div>';
        
        echo '<div class="members-count-container" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 0; color: #9e9e9e; font-family: \'Product Sans\', sans-serif; margin-left: -10px;">';
        echo '</div>';

       

        echo '</a>';

  
        echo '<p class="group-name" style="margin: 0;">' . $displayCommunityName . '</p>';
        echo '<p class="name" style="margin: 0;">' . $username . '</p>';
    

        echo '</div>';
        echo '</div>';
        echo '</div>';

        $communityCount++;
    }

    $stmt->close();
    $conn->close();
}
?>


<?php displayCommunitiesForProfile($profileUsername);?>
</div>

<div class="container">


<div class="posts-title">
<h6><?php if (isset($_GET['username'])) { echo "" . htmlspecialchars($_GET['username'] . "'s Posts"); } ?></h6>
</div>
    <div class="row">
        <?php
        $leftPosts = array();
        $rightPosts = array();

        foreach ($posts as $index => $post) {
            if ($index % 2 === 0) {
                $leftPosts[] = $post;
            } else {
                $rightPosts[] = $post;
            }
        }
        ?>
        <div class="col s12 m6">
            <?php
            displayPosts($rightPosts); // Display posts in the right column
            ?>
        </div>
        <div class="col s12 m6">
            <?php
            displayPosts($leftPosts); // Display posts in the left column
            ?>
        </div>
    </div>

    <button type="button" class="modal-trigger post-button" data-target="write-post-modal"><i class="material-icons">create</i></button>
</div>


    <button type="button" class="modal-trigger post-button" data-target="write-post-modal"><i class="material-icons">create</i></button>

</div>
