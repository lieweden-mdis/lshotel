<?php
session_start();
require 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L's HOTEL - INDEX</title>
    <link rel="icon" href="img/icon.jpg">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
    <section class="banner">
        <img src="img/banner.jpg" alt="Banner Image">
        <div class="booking-form">
            <h2>Book a room</h2>
            <form>
                <div class="form-content">
                    <label for="num-rooms">Rooms:</label>
                    <select id="num-rooms" name="num-rooms">
                        <option value="1">1 room</option>
                        <option value="2">2 rooms</option>
                        <option value="3">3 rooms</option>
                        <option value="4">4 rooms</option>
                        <option value="5">5 rooms</option>
                    </select>

                    <label for="check-in">Check-in time:</label>
                    <input type="date" id="check-in" name="check-in">

                    <label for="check-out">Check-out time:</label>
                    <input type="date" id="check-out" name="check-out">
                </div>
                <button type="submit">Book</button>
            </form>
        </div>
    </section>

    <!-- Room Gallery -->
    <div class="room-gallery">
        <span>Room Gallery</span>
    </div>
    <div class="room-card">
        <div class="roomtype-box" id="standard-room">
            <!-- Room image -->
            <div class="room-img-small">
                <img src="img/room-image/standard-room/standard1.webp" alt="standard-room">
            </div>
            <!-- Room simple description -->
            <div class="room-desc-header">
                <span>Standard Room</span>
            </div>
            <div class="room-simple-desc">
                <span>
                    Discover comfort and convenience in our Standard Room, ideal for both leisure and business travelers. Enjoy essential amenities and a welcoming ambiance, ensuring a relaxing stay whether you're here for a short visit or an extended stay.
                </span>
            </div>
            <div class="viewmore">
                <a href="standard-room.php" target="_blank">View More</a>
            </div>
        </div>

        <div class="roomtype-box" id="deluxe-room">
            <!-- Room image -->
            <div class="room-img-small">
                <img src="img/room-image/deluxe-room/deluxe1.webp" alt="deluxe-room">
            </div>
            <!-- Room simple description -->
            <div class="room-desc-header">
                <span>Deluxe Room</span>
            </div>
            <div class="room-simple-desc">
                <span>
                    Experience the perfect blend of comfort and luxury in our Deluxe Room, designed to cater to both leisure and business travelers. Enjoy modern amenities and a cozy atmosphere, making your stay both convenient and relaxing.
                </span>
            </div>
            <div class="viewmore">
                <a href="deluxe-room.php" target="_blank">View More</a>
            </div>
        </div>

        <div class="roomtype-box" id="triple-room">
            <!-- Room image -->
            <div class="room-img-small">
                <img src="img/room-image/triple-room/triple1.jpg" alt="triple-room">
            </div>
            <!-- Room simple description -->
            <div class="room-desc-header">
                <span>Triple Room</span>
            </div>
            <div class="room-simple-desc">
                <span>
                    Experience comfort and convenience in our well-appointed Triple Room, designed to cater to the needs of small groups or families. This room offers a perfect blend of functionality and style, ensuring a pleasant and memorable stay.
                </span>
            </div>
            <div class="viewmore">
                <a href="triple-room.php" target="_blank">View More</a>
            </div>
        </div>

        <div class="roomtype-box" id="family-suite-room">
            <!-- Room image -->
            <div class="room-img-small">
                <img src="img/room-image/family-suite-room/family-suite2.webp" alt="family-suite-room">
            </div>
            <!-- Room simple description -->
            <div class="room-desc-header">
                <span>Family Suite Room</span>
            </div>
            <div class="room-simple-desc">
                <span>
                    Experience unparalleled luxury and comfort in our Family Suite Room, designed to cater to all your needs and provide an unforgettable stay. Perfect for families, this spacious suite offers a harmonious blend of modern amenities and elegant decor.
                </span>
            </div>
            <div class="viewmore">
                <a href="family-suite-room.php" target="_blank">View More</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy;2024 L's Hotel All Rights Reserved.</p>
    </footer>
</body>
</html>
