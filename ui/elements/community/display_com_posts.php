<!-- ui/elements/community/display_com_posts.php -->

<div class="container">
    <div class="row">
        <div class="col s12 m6">
            <div class="custom-input-container">
                <div class="text-database-input">
                    <p><?php echo $_SESSION['username']; ?></p>
                </div>
                <input type="text" id="postContent" placeholder="Write something...">
            </div>
            <?php
            $leftPosts = array_slice($posts, ceil(count($posts) / 2));
            displayPosts($leftPosts);
            ?>
        </div>
        <div class="col s12 m6">
            <?php
            $rightPosts = array_slice($posts, 0, ceil(count($posts) / 2));
            displayPosts($rightPosts);
            ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Add a click event handler to the input field
    $('#postContent').on('click', function() {

        $('#write-post-modal').modal('open');
    });
});
</script>