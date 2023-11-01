<?php

if (isset($post)) {

    echo '<div class="post-content">';

    echo '<br>';

    $postTime = strtotime($post['post_time']);
    $currentTime = time();
    $timeDiff = $currentTime - $postTime;

    if ($timeDiff < 60) {
        $timeAgo = $timeDiff . ' ' . ($timeDiff == 1 ? '' : '') . '';
    } elseif ($timeDiff < 3600) {
        $timeAgo = floor($timeDiff / 60) . 'm' . (floor($timeDiff / 60) == 1 ? '' : '') . '';
    } elseif ($timeDiff < 86400) {
        $timeAgo = floor($timeDiff / 3600) . 'h' . (floor($timeDiff / 3600) == 1 ? '' : '') . '';
    } else {
        $timeAgo = floor($timeDiff / 86400) . 'd' . (floor($timeDiff / 86400) == 1 ? '' : '') . '';
    }

    echo '<span class="post-time" style="float: right;">' . $timeAgo . '</span>';

    echo '<p class="username">';
    echo '<span class="pfp"><img src="https://ssl.gstatic.com/images/branding/product/1x/avatar_circle_blue_512dp.png" alt="Profile Picture" width="40" height="40"></span>';
    echo htmlspecialchars($post['username']);
    echo '</p>';

    echo '<br>';
    if (!empty($post['image_url'])) {
        echo '<img class="post-image" src="' . $post['image_url'] . '" alt="Post Image">';
    }
    echo '<p>' . htmlspecialchars($post['content']) . '</p>';
    if (!empty($post['image_link'])) {
        echo '<a href="' . $post['image_link'] . '">Link to Image</a>';
    }
    if (!empty($post['post_link'])) {https:
        echo '<a href="' . $post['post_link'] . '">Link to Post</a>';
    }

    echo '<br>';
    echo '
    <div class="comment-icon">
        <i class="material-icons">comment</i>
    </div>

    '; // Comment icon

    echo '<br>';
    echo '<br>';

echo '<div class="comments">';

function formatTimeAgo($timestamp) {
    $currentTimestamp = time();
    $timeDiff = $currentTimestamp - strtotime($timestamp);

    if ($timeDiff < 60) {
        return $timeDiff . 's' . ($timeDiff == 1 ? '' : '') . '';
    } elseif ($timeDiff < 3600) {
        $minutes = floor($timeDiff / 60);
        return $minutes . 'm' . ($minutes == 1 ? '' : '') . '';
    } elseif ($timeDiff < 86400) {
        $hours = floor($timeDiff / 3600);
        return $hours . 'h' . ($hours == 1 ? '' : '') . '';
    } else {
        $days = floor($timeDiff / 86400);
        return $days . 'd' . ($days == 1 ? '' : '') . '';
    }
}

if (isset($comments) && is_array($comments)) {
    foreach ($comments as $comment) {

        echo '<div class="comment-container">';

        echo '<div class="comment-header">';

        echo '<div class="comment-user">';
        echo '<span class="pfp"><img src="https://ssl.gstatic.com/images/branding/product/1x/avatar_circle_blue_512dp.png" alt="Profile Picture" width="40" height="40"></span>';
        echo '</div>';

        echo '<p>' . htmlspecialchars($comment['username']) . '</p>';
        echo '&nbsp';
        echo '<p class="comment-created">' . formatTimeAgo($comment['created_at']) . '</p>';
        echo '</div>';

       echo '<div class="comment-content">';
       echo '<p>' . htmlspecialchars($comment['comment_content']) . '</p>';
         echo '</div>'; 
        echo '</div>'; 
    }

}

echo '<div class="comment-form">';
echo '<form method="post" action="submit_comment.php">';
echo '<div class="comment-row">';

echo '<span class="pfp"><img src="https://ssl.gstatic.com/images/branding/product/1x/avatar_circle_blue_512dp.png" alt="Profile Picture" width="40" height="40"></span>';

echo '<textarea name="commentContent" placeholder="Write a comment..."></textarea>';

echo '<button type="submit" class="waves-effect waves-light btn-flat">POST</button>';

echo '</div>'; 
echo '<input type="hidden" name="postID" value="' . $postID . '">';
echo '</form>';
echo '</div>'; 

echo '</div>'; 

}

?>