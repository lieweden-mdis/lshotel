<?php
// Check if a session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in and has the appropriate user type
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['user_type'], ['staff', 'admin'])) {
    header("Location: ../login.php");
    exit();
}
?>
