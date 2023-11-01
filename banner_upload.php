<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        $maxFileSize = isModerator($username) ? '100M' : '1M'; 

        ini_set('upload_max_filesize', $maxFileSize);
        ini_set('post_max_size', $maxFileSize);

        $targetDirectory = "banners/";

        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        $newFileName = $username . "_banner.jpg";
        $targetPath = $targetDirectory . $newFileName;

        if (isset($_FILES["profileImage"]) && $_FILES["profileImage"]["error"] == UPLOAD_ERR_OK) {
            $tempName = $_FILES["profileImage"]["tmp_name"];

            if (move_uploaded_file($tempName, $targetPath)) {
                echo "File uploaded successfully.";
                echo '<script type="text/javascript">javascript:history.go(-1);</script>';
            } else {
                echo "Failed to move the file.";
                echo '<script type="text/javascript">javascript:history.go(-1);</script>';
            }
        } else {
            echo "File upload error.";
            echo '<script type="text/javascript">javascript:history.go(-1);</script>';
        }
    } else {
        echo "User is not logged in.";
        echo '<script type="text/javascript">javascript:history.go(-1);</script>';
    }
} else {
    echo "Invalid request.";
    echo '<script type="text/javascript">javascript:history.go(-1);</script>';
}

function isModerator($username) {

    $pdo = new PDO('mysql:host=sql202.infinityfree.com:3306;dbname=if0_34940695_foogle', 'if0_34940695', 'TvwWIwpIBagJ1');
    $stmt = $pdo->prepare("SELECT * FROM moderators WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
}
?>