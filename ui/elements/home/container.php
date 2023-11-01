

<div class="container">

<style>
@media screen and (min-width: 1400px) and (max-width: 1920px) {
.container {

    margin-top: -37%;
}
}


@media screen and (min-width: 800px) and (max-width: 1500px) {
.container {
    margin-top: 70%;
    width: 69%;
scale: 0.8;
left: -1.5%;
position: relative;
}
}
@media screen and (min-width: 1000px) and (max-width: 1300px) {
.container {
    margin-top: 144%;
    width: 69%;
scale: 0.8;
left: -1.5%;
position: relative;
}
}
@media screen and (min-width: 800px) and (max-width: 1100px) {
.container {
    margin-top: 157%;
    width: 69%;
scale: 0.8;
left: -1.5%;
position: relative;
}
}
</style>
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
            <div class="custom-input-container">
                <div class="text-database-input">
                    <p><?php echo $_SESSION['username']; ?></p>
                </div>
                <input type="text" id="postContent" placeholder="Write something...">
            </div>
            <?php
            displayPosts($rightPosts); 
            ?>
        </div>
        <div class="col s12 m6">
            <?php
            displayPosts($leftPosts);
            ?>
        </div>
    </div>
    <button type="button" class="modal-trigger post-button" data-target="write-post-modal"><i class="material-icons">create</i></button>
</div>
