<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L's HOTEL - Reservation</title>
    <link rel="icon" href="img/icon.jpg">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/reservation.css">
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

    <!-- Reservation Grid -->
    <main class="reservation-grid">
        <h2>My Reservations</h2>
        <div class="grid-container">
            <div class="grid-item">
                <div class="room-card">
                    <img src="img/R.jpeg" alt="Room Photo">
                    <div class="room-details">
                        <h3>Deluxe Room</h3>
                        <p>Order ID: 123456</p>
                        <p>Check-in: 2024-07-20</p>
                        <p>Check-out: 2024-07-25</p>
                        <p>Status: Confirmed</p>
                        <button class="invoice-btn">Invoice</button>
                    </div>
                </div>
            </div>
            <!-- Repeat .grid-item for each reservation -->
            <div class="grid-item">
                <div class="room-card">
                    <img src="img/room2.jpg" alt="Room Photo">
                    <div class="room-details">
                        <h3>Standard Room</h3>
                        <p>Order ID: 123457</p>
                        <p>Check-in: 2024-08-01</p>
                        <p>Check-out: 2024-08-05</p>
                        <p>Status: Pending</p>
                        <button class="invoice-btn">Invoice</button>
                    </div>
                </div>
            </div>
            <!-- Add more cards as needed -->
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy;2024 L's Hotel All Right Reserved.</p>
    </footer>
</body>
<!-- JavaScript -->
<script src="script/reservation.js" type="text/javascript"></script>
</html>
