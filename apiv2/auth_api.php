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
    $token = $_POST['token'];

    if (!empty($username) && !empty($token)) {

        if (verifyUserToken($username, $token)) {
            $response['status'] = 'success';
            $response['message'] = 'Token is valid.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Token is invalid or expired.';
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

function verifyUserToken($username, $token) {
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

