
<div class="friend-suggestions">

    <?php for ($i = 1; $i <= 12; $i++) { ?>
        <?php if ($i % 4 === 1) { ?>
            <div class="friend-row">
        <?php } ?>
        <div class="friend">
            <div class="friend-info">
                <div class="friend-name"><?php echo htmlspecialchars($users[$i]); ?></div>
                <div class="common-friends"><?php echo getCommonFriends($conn, $_SESSION['username'], $user[$i]); ?> friends in common</div>
                <br>
                <br>
                <br>

                <button class="follow-button"
                data-follow-status="<?php echo isFollowing($conn, $_SESSION['username'], $users[$i]) ? 'following' : 'not-following'; ?>"
                data-profile-username="<?php echo htmlspecialchars($users[$i]); ?>">
               <?php echo isFollowing($conn, $_SESSION['username'], $users[$i]) ? 'Following' : 'Follow'; ?>
               </button>

               <script>

        var followButton = document.getElementById('follow-button');
        followButton.addEventListener('click', function() {

        });
    </script>

            </div>
        </div>
        <?php if ($i % 4 === 0 || $i === 12) { ?>
            </div>
        <?php } ?>
    <?php } ?>
</div>