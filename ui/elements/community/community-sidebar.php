<!-- ui/elements/community/community-sidebar.php -->

<div class="community-sidebar">

    <?php
    $communityImageURL = $imageURL ? $imageURL : 'banners/deafult_com.png';
    ?>
<div class="imgcon">
    
    <img src="<?php echo $communityImageURL; ?>" alt="Community Image">
    <div class="dropdown-container">
        <div class="dropdown-trigger" data-target="community-dropdown">
            <a class="dropdown-trigger" href="#!" data-target="dropdown1" style="position: absolute; right: 20px;"><i class="material-icons">more_vert</i></a>
        </div>
        <ul id="community-dropdown" class="dropdown-content" style="left: -45px; top: 100px;">
            <?php

            $isOwnerOrMod = $isOwner || $isModerator;

            if ($isOwnerOrMod) {
                echo '<li><a href="#editCommunityModal" class="modal-trigger" style="font-size: 14px; color: black;">Edit Community</a></li>';

            }

            echo '<li><a href="#leaveButton" id="leaveButton" class="leaveButton" style="font-size: 14px; color: black;">Leave Community</a></li>';
            ?>
        </ul>
    </div>
    
</div>
<div id="editCommunityModal" class="modal">
    <div class="modal-content">
        <h4>Edit Community</h4>
        <form id="editCommunityForm" action="community_edit.php" method="POST" enctype="multipart/form-data">

            <div class="input-field">
                <input type="text" id="communityDisplayName" name="communityDisplayName" required>
                <label for="communityDisplayName">Community Display Name</label>
            </div>

            <input type="hidden" id="communityName" name="communityName" value="<?php echo htmlspecialchars($communityName); ?>">
            <input type="hidden" id="communityID" name="communityID" value="<?php echo $communityID; ?>">

            <div class="input-field">
                <textarea id="communityDescription" class="materialize-textarea" name="communityDescription"></textarea>
                <label for="communityDescription">Community Description</label>
            </div>

            <div class="input-field">
        
                <label for="communityImage">Community Image (optional)</label>
                <br><br>
                <input type="file" id="communityImage" name="communityImage" accept="image/*">
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-light btn-flat">Cancel</a>
        <button type="submit" form="editCommunityForm" class="waves-effect waves-light btn">Save Changes</button>
    </div>
</div>




<div class="stuff">
    <div class="members">
        <p>Members: <?php echo $memberCount; ?></p>
    </div>
    <div class="c-name">
        <h1><?php 

        $displaycommunityName = str_replace('_', ' ', $displaycommunityName);

        echo $displaycommunityName; 
       
        ?> </h1>
<div class="c-desc">
    <p><?php echo $communityDescription; ?></p>
</div>

    <div class="buttons">
        <?php

        $username = $_SESSION['username'];
        $isMember = strpos($membersList, $username . ':member') !== false;
        $isOwner = strpos($membersList, $username . ':owner') !== false;
        $isModerator = strpos($membersList, $username . ':moderator') !== false;

        if ($isMember) {

            echo '<a class="waves-effect waves-light btn" id="memberButton">Member</a>';
        } elseif ($isOwner || $isModerator) {

            echo '<a class="waves-effect waves-light btn">Moderate</a>';
        } else {

            echo '<a class="waves-effect waves-light btn" id="joinButton">Join</a>';
        }
        ?>
    </div>
</div>

