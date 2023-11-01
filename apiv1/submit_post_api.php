<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
$isCommandLine = php_sapi_name() === 'cli';

$rateLimit = 2.5;

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $isCommandLine) {
    if ($isCommandLine) {
        $username = $argv[1];
        $password = $argv[2];
        $postContent = $argv[3];
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $postContent = $_POST['postContent'];
    }

    $rateLimitFile = sys_get_temp_dir() . '/' . $username . '_ratelimit.txt';
    if (!isRateLimited($rateLimitFile, $rateLimit)) {
        if (isValidUser($username, $password)) {

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

                if ($isCommandLine) {
                    $response['status'] = 'success';
                    $response['message'] = "Post successfully submitted via command line.";
                } else {
                    $response['status'] = 'success';
                    $response['message'] = 'Post successfully submitted.';
                }
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid username or password.';
        }

        echo json_encode($response);
        exit;
    } else {
        if ($isCommandLine) {
            $response['status'] = 'error';
            $response['message'] = "Error: You can only post once every $rateLimit second(s).";
        } else {
            $response['status'] = 'error';
            $response['message'] = "Error: You can only post once every $rateLimit second(s).";
        }
        echo json_encode($response);
        exit;
    }
}

if (!$isCommandLine) {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request or missing parameters.';
    header('Content-Type: application/json');
    echo json_encode($response);
}

function isRateLimited($rateLimitFile, $rateLimit) {
    if (!file_exists($rateLimitFile) || (time() - filemtime($rateLimitFile)) > $rateLimit) {
        touch($rateLimitFile);
        return false;
    } else {
        return true;
    }
}

function isValidUser($username, $password) {

    include("../important/db.php");

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        return false;
    }

    $query = "SELECT password FROM user WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($storedPassword);
    $stmt->fetch();

    if (password_verify($password, $storedPassword)) {
        return true;
    }

    return false;
}
?>
