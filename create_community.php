<?php
session_start();

include("important/db.php");

$main_conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($main_conn->connect_error) {
    die("Connection to main database failed: " . $main_conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $communityName = $_POST['name'];
    $communityDescription = $_POST['description'];
    $creatorUsername = $_SESSION['username']; 

    function generateRandomNumbers($length = 6) {
        $characters = '0123456789';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    $originalCommunityName = $_POST['name'];

if (!preg_match('/^[A-Za-z0-9_]+$/', $originalCommunityName)) {

    $randomNumbers = generateRandomNumbers();

    $communityName = $randomNumbers . $originalCommunityName;
} else {
    $communityName = $originalCommunityName;
}

    $query = "INSERT INTO communities (name, description, creator_username, members, members_list, display_name) VALUES (?, ?, ?, 1, ?, ?)";
    $stmt = $main_conn->prepare($query);
    $membersInfo = $creatorUsername . ":owner"; 
    $stmt->bind_param("sssss", $communityName, $communityDescription, $creatorUsername, $membersInfo, $originalCommunityName); 

    if ($stmt->execute()) {

        $stmt->close();

        $main_conn->close();

        include("important/db-com.php");

        $separate_conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($separate_conn->connect_error) {
            die("Connection to separate database failed: " . $separate_conn->connect_error);
        }

        $createTableQuery = "
            CREATE TABLE IF NOT EXISTS $communityName (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                content TEXT,
                image_url VARCHAR(255),
                image_link_url VARCHAR(255),
                post_link_url VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";

        if ($separate_conn->query($createTableQuery) === TRUE) {

            echo "Table created successfully in the separate database with name: $communityName";
        } else {

            echo "Error creating table in the separate database: " . $separate_conn->error;
        }

        $separate_conn->close();
    } else {

        $response = ["success" => false, "message" => "Error creating community in the main database."];
        echo json_encode($response);
    }
} else {

    http_response_code(418); 
    echo "Invalid request method.";
}
?>