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
    <title>L's HOTEL - RESERVATION</title>
    <link rel="icon" href="img/icon.jpg">
</head>
<body>
    <header>
        <div>
			<img src="img/logo.png" alt="Logo">
        </div>
        <div class="user-links">
            <a href="login.html">Login</a>
            <a href="register.html">Register</a>
            <a href="profile.html"><img src="img/profile-icon.png" alt="profile-icon"></a>
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
        <a href="profile.html"><i class="fa-solid fa-user"></i>My Profile</a>
        <a href="reservation.html"><i class="fa-regular fa-calendar-check"></i>My Reservation</a>
        <a href="receipt.html"><i class="fa-solid fa-receipt"></i>My Receipt</a>
        <a href="login.php/logout"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
    </div>
    <div class="content">
        <div class="account-header">
            <span>My Reservation</span>
        </div>
        <div class="reservation-table" id="reservation-table">
          <div class="table-header">
              <div class="header-cell">Reservation ID</div>
              <div class="header-cell">Check-in Date</div>
              <div class="header-cell">Check-out Date</div>
              <div class="header-cell">Guests</div>
              <div class="header-cell">Room Level</div>
              <div class="header-cell">Room Number</div>
              <div class="header-cell">Status</div>
          </div>
      </div>
      <p id="no-reservation-message" style="display: none;">No reservations found.</p>
 </div>     
</section>
<!--Footer-->
<footer>
    <p>&copy;2024 L's Hotel  All Right Reserved.</p>
</footer>

<!--Javascript-->
</body>
</html>