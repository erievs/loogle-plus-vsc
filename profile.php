<?php
session_start();
$profileUsername = isset($_GET['username']) ? $_GET['username'] : '';
if (!empty($profileUsername)) {
    include 'templetes/user_templete.php';
} else {
    echo "Profile not found.";
}
?>
