<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== true) {
    header("Location: login.php");
    exit;
}
?>
