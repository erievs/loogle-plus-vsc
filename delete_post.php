<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SESSION['username']) && isset($_GET['index'])) {
    $postIndex = $_GET['index'];

    $postDatabase = 'posts.txt';
    $posts = [];

    if (file_exists($postDatabase)) {
        $posts = file($postDatabase, FILE_IGNORE_NEW_LINES);
    }

    if ($postIndex >= 0 && $postIndex < count($posts) && $_SESSION['username'] === 'your_username') {
        array_splice($posts, $postIndex, 1);
        file_put_contents($postDatabase, implode(PHP_EOL, $posts));
    }
}

header('Location: index.php'); // Redirect back to the main page
?>
