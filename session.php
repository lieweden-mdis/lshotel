<?php
session_start();

$userLoggedIn = false;
if (isset($_SESSION['user_id'])) {
    $userLoggedIn = true;
    $firstName = $_SESSION['first_name'];
    $lastName = $_SESSION['last_name'];
    $userName = $firstName . ' ' . $lastName;
}
?>
