<?php
session_start();
$postDatabase = 'posts.txt';
$posts = [];

if (file_exists($postDatabase)) {
    $posts = file($postDatabase, FILE_IGNORE_NEW_LINES);
}

$viewedUsername = $_GET['username'] ?? ''; // Get the viewed username from the URL

// Fetch user data and posts for the viewed user (you can replace this with your database queries)
$viewedUserPosts = array_filter($posts, function($post) use ($viewedUsername) {
    return strpos($post, $viewedUsername) === 0;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your head content here -->
</head>
<body>
    <header class="nav-wrapper">
        <!-- Your header content here -->
    </header>

    <!-- Display the viewed user's information and posts -->
    <div class="container">
        <div class="row">
            <div class="col s12 m6 left-column">
                <h5><?php echo $viewedUsername; ?>'s Posts</h5>
                <?php
                foreach ($viewedUserPosts as $post) {
                    $postContent = htmlspecialchars(explode(":", $post)[1]);

                    echo '<div class="post">';
                    echo '<p>' . $postContent . '</p>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Your scripts and footer content here -->
</body>
</html>
