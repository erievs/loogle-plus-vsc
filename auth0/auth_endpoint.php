<?php
session_start();

// Your client application should send the authorization code to this URL
if (isset($_POST['code'])) {
    $code = $_POST['code'];

    // Validate the code (you should validate it against your database)
    if ($_SESSION['authorization_code'] === $code) {
        $accessToken = bin2hex(random_bytes(16)); // Generate an access token
        echo json_encode(['access_token' => $accessToken]);
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['error' => 'invalid_grant']);
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'invalid_request']);
}
?>
