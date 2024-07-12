<?php
require 'header.php';
require 'config.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user details from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT first_name, last_name, email, phone_number FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($firstName, $lastName, $email, $phone);
$stmt->fetch();
$stmt->close();
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
    <!--Header and Nav included through header.php-->

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
            <span><?php echo htmlspecialchars($lastName . ' ' . htmlspecialchars($firstName)); ?></span>
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