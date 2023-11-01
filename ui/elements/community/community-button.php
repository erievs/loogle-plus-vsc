<!-- ui/elements/community/community-button.php -->

<div class="btn-con">
       <?php

        $username = $_SESSION['username'];
        $isMember = strpos($membersList, $username . ':member') !== false;
        $isOwner = strpos($membersList, $username . ':owner') !== false;
        $isModerator = strpos($membersList, $username . ':moderator') !== false;

        if ($isMember) {
      
            echo '<button type="button" class="modal-trigger post-button" data-target="write-post-modal"><i class="material-icons">create</i></button>';
        } elseif ($isOwner || $isModerator) {
    
            echo '<button type="button" class="modal-trigger post-button" data-target="write-post-modal"><i class="material-icons">create</i></button>';
        } else {
      

        }
        ?>
</div>