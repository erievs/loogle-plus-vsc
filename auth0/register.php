<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection code here
    // Replace with your actual database connection details
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "nicknick";
    $dbName = "loogle-auth";

    // Create a database connection
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user input from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $google_id = $_POST['google_id'];

    // Insert user data into the users table
    $sql = "INSERT INTO users (name, email, google_id) VALUES ('$name', '$email', '$google_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
