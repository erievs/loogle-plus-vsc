<div class="friend-suggestions">
    <?php if (count($users) > 0) { ?>

        <?php for ($i = 0; $i < count($users); $i++) { ?>
            <?php if ($i % 4 === 0) { ?>
                <div class="friend-row">
            <?php } ?>
            <div class="friend">
                <div class="friend-info">
                    <div class="friend-name"><?php echo htmlspecialchars($users[$i]); ?></div>
                    <div class="common-friends"><?php echo getCommonFriends($conn, $_SESSION['username'], $users[$i]); ?> friends in common</div>
                </div>
            </div>
            <?php if ($i % 4 === 3 || $i === count($users) - 1) { ?>
                </div>
            <?php } ?>
        <?php } ?>
    <?php } else { ?>
        <p>No followers yet.</p>
    <?php } ?>
</div>