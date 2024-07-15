<?php
session_start();
require 'header.php';
require 'config.php';

// Fetch room availability from the database
$sql = "SELECT room_type, room_availability FROM rooms";
$result = $conn->query($sql);

$availability = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $availability[$row['room_type']] = (int)$row['room_availability'];
    }
}

$conn->close();
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
    <style>
        .availability {
            color: green;
            margin-top: 5px;
            font-weight: bold;
        }
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <section class="banner">
        <img src="img/banner.jpg" alt="Banner Image">
        <div class="booking-form">
            <h2>Book a room</h2>
            <form id="index-booking-form" action="booking.php" method="get">
                <div class="form-row">
                    <div class="form-group">
                        <label for="room-type">Room Type:</label>
                        <select id="room-type" name="roomType" required>
                            <option value="Standard Room">Standard Room</option>
                            <option value="Deluxe Room">Deluxe Room</option>
                            <option value="Triple Room">Triple Room</option>
                            <option value="Family Suite Room">Family Suite Room</option>
                        </select>
                        <div id="availability" class="availability"></div>
                    </div>
                    <div class="form-group small-width">
                        <label for="room-quantity">Room Quantity:</label>
                        <input type="number" id="room-quantity" name="roomQuantity" min="1" required>
                    </div>
                    <div class="form-group large-width">
                        <label for="check-in">Check In Date:</label>
                        <input type="date" id="check-in" name="checkInDate" required>
                    </div>
                    <div class="form-group large-width">
                        <label for="check-out">Check Out Date:</label>
                        <input type="date" id="check-out" name="checkOutDate" required>
                    </div>
                </div>
                <div class="form-row">
                    <button type="submit" class="center-button">Book Now</button>
                </div>
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

        <div class=" roomtype-box" id="family-suite-room">
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

    <!-- Modal Dialog Box -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modal-message"></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roomTypeElement = document.getElementById('room-type');
            const roomQuantityElement = document.getElementById('room-quantity');
            const checkInElement = document.getElementById('check-in');
            const checkOutElement = document.getElementById('check-out');
            const availabilityElement = document.getElementById('availability');
            const modal = document.getElementById('myModal');
            const modalMessage = document.getElementById('modal-message');
            const span = document.getElementsByClassName('close')[0];

            const roomAvailability = <?php echo json_encode($availability); ?>;

            function updateAvailability() {
                const selectedRoomType = roomTypeElement.value;
                const availableRooms = roomAvailability[selectedRoomType] || 0;
                availabilityElement.textContent = `Available Rooms: ${availableRooms}`;
                roomQuantityElement.max = availableRooms;
            }

            roomTypeElement.addEventListener('change', updateAvailability);

            document.getElementById('index-booking-form').addEventListener('submit', function(event) {
                const selectedRoomType = roomTypeElement.value;
                const availableRooms = roomAvailability[selectedRoomType] || 0;
                const requestedRooms = parseInt(roomQuantityElement.value, 10);
                const checkInDate = new Date(checkInElement.value);
                const checkOutDate = new Date(checkOutElement.value);

                if (requestedRooms > availableRooms) {
                    event.preventDefault();
                    modalMessage.textContent = `You only can book for ${availableRooms} room(s)`;
                    modal.style.display = 'block';
                } else if (checkOutDate < checkInDate) {
                    event.preventDefault();
                    modalMessage.textContent = `Check-out date must be after or the same as the check-in date.`;
                    modal.style.display = 'block';
                }
            });

            span.onclick = function() {
                modal.style.display = 'none';
            };

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };

            // Trigger change event to initialize availability display
            roomTypeElement.dispatchEvent(new Event('change'));
        });
    </script>
</body>
</html>
