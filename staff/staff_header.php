<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'staff') {
    header("Location: ../login.php");
    exit();
}
?>
