<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['staff_id'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

// Function to get full name
function getFullName() {
    if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
        return $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
    }
    return '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L's HOTEL - PROFILE</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/account.css">
</head>
<body>
    <header>
        <div>
            <img src="img/logo.png" alt="Logo">
        </div>
        <div class="user-links">
            <span>Welcome, <?php echo getFullName(); ?>!</span>
            <a href="logout.php">Logout</a>
            <a href="profile.php"><img src="img/profile-icon.png" alt="profile-icon"></a>
        </div>
    </header>
    
    <nav>
        <a href="index.html">HOME</a>
        <a href="room.html">ROOM</a>
        <a href="facilities.html">FACILITIES</a>
        <a href="dining.html">DINING</a>
        <a href="about.html">ABOUT</a>
    </nav>

    <!--Profile-->
    <section class="account">
        <div class="sidemenu">
            <a href="profile.php"><i class="fa-solid fa-user"></i>My Profile</a>
            <a href="reservation.html"><i class="fa-regular fa-calendar-check"></i>My Reservation</a>
            <a href="receipt.html"><i class="fa-solid fa-receipt"></i>My Receipt</a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
        </div>
        <div class="content">
            <div class="account-header">
                <span>My Profile</span>
            </div>
            <div class="profile">
                <fieldset class="box">
                    <legend>Name</legend>
                    <span><?php echo getFullName(); ?></span>
                    <button type="button">Edit</button>
                </fieldset>

                <fieldset class="box">
                    <legend>Email</legend>
                    <span><?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?></span>
                    <button type="button">Edit</button>
                </fieldset>

                <fieldset class="box">
                    <legend>Phone Number</legend>
                    <span><?php echo isset($_SESSION['phone_number']) ? $_SESSION['phone_number'] : ''; ?></span>
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
</html>
