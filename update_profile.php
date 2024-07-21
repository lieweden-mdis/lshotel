<?php
session_start();
require 'config.php'; // Assuming you have a config.php for database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have some logic here to update the profile in the database
    $userId = $_SESSION['user']['id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];

    // Update profile query
    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone_number = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $firstName, $lastName, $email, $phoneNumber, $userId);

    if ($stmt->execute()) {
        $_SESSION['update_message'] = "Profile edited successfully, please log in again.";
        // Destroy session to log the user out
        session_destroy();
        // Redirect to login page
        header("Location: login.php");
        exit;
    } else {
        // Handle error
        $_SESSION['update_message'] = "An error occurred. Please try again.";
        header("Location: profile.php");
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
