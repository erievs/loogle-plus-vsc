<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo '<script>window.location.href = "auth/login.php";</script>';
    exit; 
}
?>