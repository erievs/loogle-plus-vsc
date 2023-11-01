<?php

session_start();

header("Content-Type: application/json");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Credentials: true");

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {

        include("../important/db.php");

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            $response['status'] = 'error';
            $response['message'] = "Connection failed: " . $conn->connect_error;
        } else {

            $query = "SELECT password FROM user WHERE username = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($storedPassword);
            $stmt->fetch();

            if (password_verify($password, $storedPassword)) {

                $token = generateUserToken($username);

                $_SESSION['user_token'] = $token;

                $response['status'] = 'success';
                $response['message'] = 'Authentication successful, Token Was Made.';
                $response['token'] = $token;
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Authentication failed, No Token Will Be Made.';
            }

            $stmt->close();
            $conn->close();
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

function generateUserToken($username) {

    $validityTimestamp = time() + (7 * 24 * 60 * 60); 

    $token = base64_encode($username . '18' . ':' . $validityTimestamp);

    return $token;
}