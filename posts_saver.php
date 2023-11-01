<?php
$url = 'mobile_posts.php';
$saveFile = 'webpage_content.txt';

while (true) {
    // Fetch the webpage content
    $content = file_get_contents($url);

    if ($content !== false) {
        // Append the content to the text file
        file_put_contents($saveFile, $content, FILE_APPEND);
    } else {
        echo "Failed to fetch content from the URL.\n";
    }

    // Wait for 5 seconds before the next fetch
    sleep(5);
}

