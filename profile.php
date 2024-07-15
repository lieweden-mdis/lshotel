<?php
require 'config.php'; // Include database connection

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user']['id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user details from the database
$user_id = $_SESSION['user']['id'];
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE); // Ensure this matches your config.php settings

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT first_name, last_name, email, phone_number FROM users WHERE id = ?");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName, $email, $phone);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Hotel">
    
    <!--Icon-->  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!--Font Family-->
    
    <!--CSS Stylesheet-->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/account.css">
    
    <title>L's HOTEL - PROFILE</title>
    <link rel="icon" href="img/icon.jpg">
</head>
<body>
    <?php include 'header.php'; ?> <!-- Include the header file -->

    <!--Profile-->
    <section class="account">
      <div class="sidemenu">
        <a href="profile.php"><i class="fa-solid fa-user"></i>My Profile</a>
        <a href="reservation.php"><i class="fa-regular fa-calendar-check"></i>My Reservation</a>
        <a href="receipt.php"><i class="fa-solid fa-receipt"></i>My Receipt</a>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
      </div>
      <div class="content">
        <div class="account-header">
          <span>My Profile</span>
        </div>
        <div class="profile">
          <fieldset class="box">
            <legend>Name</legend>
            <span><?php echo htmlspecialchars($lastName . ' ' . $firstName); ?></span>
            <button type="button">Edit</button>
          </fieldset>

          <fieldset class="box">
            <legend>Email</legend>
            <span><?php echo htmlspecialchars($email); ?></span>
            <button type="button">Edit</button>
          </fieldset>

          <fieldset class="box">
            <legend>Phone Number</legend>
            <span><?php echo htmlspecialchars($phone); ?></span>
            <button type="button">Edit</button>
          </fieldset>

          <fieldset class="box">
            <legend>Password</legend>
            <span>*********</span>
            <button type="button">Edit</button>
          </fieldset>
        </div>
      </div>
    </section>
    <!--Footer-->
    <footer>
      <p>&copy;2024 L's Hotel  All Right Reserved.</p>
  </footer>
</body>
<!--Javascript-->
<script src="script/profile.js" type="text/javascript"></script>
</html>
