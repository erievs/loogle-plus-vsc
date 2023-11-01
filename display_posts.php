<?php
function displayPosts($posts) {

    $loggedInUsername = $_SESSION['username'];

    foreach ($posts as $post) {
        $post_id = $post['id']; 
        $postUsername = $post['username'];
        $postContent = htmlspecialchars($post['content']);
        $postImageURL = $post['image_url'];
        $timestamp = strtotime($post['created_at']); 

        $currentTime = time();
        $timeDifference = $currentTime - $timestamp;

        if ($timeDifference < 60) {
            $formattedTimestamp = $timeDifference == 1 ? '1s' : $timeDifference . 's'; 
        } elseif ($timeDifference < 3600) {
            $minutes = floor($timeDifference / 60);
            $formattedTimestamp = $minutes == 1 ? '1m' : $minutes . 'm'; 
        } elseif ($timeDifference < 86400) {
            $hours = floor($timeDifference / 3600);
            $formattedTimestamp = $hours == 1 ? '1h' : $hours . 'h'; 
        } else {
            $days = floor($timeDifference / 86400);
            $formattedTimestamp = $days == 1 ? '1d' : $days . 'd'; 
        }

        echo '<div class="post database-post">'; 
        echo '<p>';

        if ($postUsername === $loggedInUsername) {
            echo '<span class="timestamp-right" style="font-family: "Product Sans", sans-serif; color: #B0B0B0;">' . $formattedTimestamp . '</span>';
            echo '<span class="username"><a href="profile.php?username=' . $postUsername . '">' . $postUsername . '</a></span>';
            echo '<a class="more_vert"><i class="material-icons">more_vert</i></a>';
            echo '<br>';
        } else {
            echo '<span class="timestamp-right" style="font-family: "Product Sans", sans-serif; color: #B0B0B0;">' . $formattedTimestamp . '</span>';
            echo '<span class="username"><a href="profile.php?username=' . $postUsername . '">' . $postUsername . '</a></span>';
            echo '<br>';
        }

        echo '<p>' . $postContent . '</p>';

        echo '</p>';
        echo '<br>';
        echo '<br>';

        if (!empty($postImageURL)) {
            echo '<img src="' . $postImageURL . '" alt="Post Image">';
        }

        if (!empty($imageLink)) {
            echo '<a href="' . $imageLink . '">Link to Image</a>';
        }

        if (!empty($postLink)) {
            echo '<a href="' . $postLink . '">Link to Post</a>';
        }

        echo '<a href="view_post.php?post_id=' . $post_id . '">';
        echo '<div class="comment-icon">';
        echo '<i class="material-icons">comment</i>';
        echo '</div>';
        echo '</a>';

        getRandomCommentForPost($post_id);

        echo '</div>';
    }

}
function getRandomCommentForPost($post_id) {

    include("important/db.php");

    $conn = mysqli_connect("$db_host", "$db_user", "$db_pass", "$db_name");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM comments WHERE post_id = ? ORDER BY RAND() LIMIT 1";

    if ($stmt = mysqli_prepare($conn, $sql)) {

        mysqli_stmt_bind_param($stmt, "i", $post_id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $comment = mysqli_fetch_assoc($result);

            echo '<div class="comment horizontal-list">';

            echo '<span class="pfp2"><img class="comment-profile-pic" src="https://ssl.gstatic.com/images/branding/product/1x/avatar_circle_blue_512dp.png" alt="Profile Picture" width="30" height="30"></span>';
            echo '<span class="comment-username">' . htmlspecialchars($comment['username']) . '</span>';
            echo '<span class="comment-content" style="font-family: \'Product Sans\', sans-serif; color: #B0B0B0;">' . htmlspecialchars($comment['comment_content']) . '</span>';
            echo '</div>';

        } else {

        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
}

?>