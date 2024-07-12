<?php
include 'config.php';


// Function to get room price
function getRoomPrice($conn, $roomType) {
    $stmt = $conn->prepare("SELECT room_price FROM rooms WHERE room_type = ?");
    $stmt->bind_param("s", $roomType);
    $stmt->execute();
    $stmt->bind_result($room_price);
    $stmt->fetch();
    $stmt->close();
    return $room_price;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L's HOTEL - ROOM</title>
    <link rel="icon" href="img/icon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/room.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="room-container">
        <h1>ROOM</h1>
        <?php
        $rooms = [
            [
                'type' => 'Standard Room',
                'image' => 'img/room-image/standard-room/standard1.webp',
                'description' => 'Our Standard Rooms offer you a comfortable and economical choice.'
            ],
            [
                'type' => 'Deluxe Room',
                'image' => 'img/room-image/deluxe-room/deluxe1.webp',
                'description' => 'Enjoy the comfort of our Deluxe Rooms, equipped with modern amenities and beautiful views.'
            ],
            [
                'type' => 'Triple Room',
                'image' => 'img/room-image/triple-room/triple1.jpg',
                'description' => 'Discover comfort and convenience in our Triple Room, ideal for small groups or families.'
            ],
            [
                'type' => 'Family Suite Room',
                'image' => 'img/room-image/family-suite-room/family-suite2.webp',
                'description' => 'Spacious family suites, offering more space and facilities.'
            ]
        ];

        foreach ($rooms as $room) {
            $price = getRoomPrice($conn, $room['type']);
            echo '<div class="room">';
            echo '<img src="' . $room['image'] . '" alt="' . $room['type'] . '">';
            echo '<div class="room-details">';
            echo '<h2>' . $room['type'] . '</h2>';
            echo '<p>' . $room['description'] . '</p>';
            echo '<p>Price: RM ' . $price . ' / Night</p>';
            echo '<div class="view-details">';
            echo '<a href="' . strtolower(str_replace(' ', '-', $room['type'])) . '.php" target="_self">View Details</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>

    <footer>
        <p>&copy;2024 L's Hotel All Right Reserved.</p>
    </footer>
</body>
</html>
<?php
$conn->close();
?>
