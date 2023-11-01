<button id="edit-profile-button" class="edit-profile-button"><p>EDIT PROFILE</p></button>

<div id="edit-profile-modal" class="edit-profile-modal">
    <div class="edit-profile-content">
        <span class="close-button">&times;</span>
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