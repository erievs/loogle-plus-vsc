<?php
header("Content-Type: application/json");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

function getPostsFromDatabase($page = 1, $perPage = 10) {

    include("../important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $startRecord = ($page - 1) * $perPage;

    $query = "SELECT * FROM posts ORDER BY created_at DESC LIMIT ?, ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $startRecord, $perPage);
    $stmt->execute();
    $result = $stmt->get_result();

    $posts = array();

    while ($post = $result->fetch_assoc()) {
        if (!empty($post['image_url'])) {

            $image_url = 'http://loogleplus.free.nf' . $post['image_url'];
        } else {

            $image_url = null;
        }
        $posts[] = array(
            'id' => $post['id'],
            'username' => $post['username'],
            'content' => htmlspecialchars($post['content']),
            'image_url' => $image_url,
            'post_link' => $post['post_link'],
            'created_at' => $post['created_at']
        );
    }

    $stmt->close();
    $conn->close();

    return $posts;
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$postsData = getPostsFromDatabase($page);

echo json_encode($postsData);
?>