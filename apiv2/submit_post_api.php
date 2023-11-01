<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Credentials: true");

$rateLimit = 2.5;

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents("php://input"), true);

    if (isset($requestData['username']) && isset($requestData['token'])) {
        $username = $requestData['username'];
        $token = $requestData['token'];

        $rateLimitFile = sys_get_temp_dir() . '/' . $username . '_ratelimit.txt';
        if (!isRateLimited($rateLimitFile, $rateLimit)) {
            if (authenticateUser($username, $token)) {

                if (isset($requestData['postContent'])) {
                    $postContent = $requestData['postContent'];

                    include("../important/db.php");

                    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

                    if ($conn->connect_error) {
                        $response['status'] = 'error';
                        $response['message'] = "Connection failed: " . $conn->connect_error;
                    } else {

                        $query = "INSERT INTO posts (username, content, created_at) VALUES (?, ?, NOW())";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("ss", $username, $postContent);
                        $stmt->execute();

                        $stmt->close();
                        $conn->close();

                        $response['status'] = 'success';
                        $response['message'] = 'Post successfully submitted.';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Missing post content.';
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Authentication failed or invalid token.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = "Error: You can only post once every $rateLimit second(s).";
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Invalid request or missing parameters.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);

function isRateLimited($rateLimitFile, $rateLimit) {
    if (!file_exists($rateLimitFile) || (time() - filemtime($rateLimitFile)) > $rateLimit) {
        touch($rateLimitFile);
        return false;
    } else {
        return true;
    }
}

function authenticateUser($username, $token) {
 $tokenParts = explode(':', base64_decode($token));
 if (count($tokenParts) !== 2) {
     return false;
 }
 $tokenData = explode('18', $tokenParts[0]);
 if (count($tokenData) !== 2) {
     return false;
 }
 $tokenPassword = $tokenData[0];
 $tokenTimestamp = $tokenParts[1];

 $currentTimestamp = time();

 if ($tokenPassword === $username && $tokenTimestamp >= $currentTimestamp) {
     return true;
 } else {
     return false;
 }
}
?>
