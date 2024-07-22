<?php
include '../config.php';

$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : '';
$user_info = isset($_GET['user_info']) ? $_GET['user_info'] : '';
$check_in_date = isset($_GET['check_in_date']) ? $_GET['check_in_date'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$room_type = isset($_GET['room_type']) ? $_GET['room_type'] : '';

$sql = "SELECT bookings.booking_id, rooms.room_type, bookings.check_in_date, bookings.check_out_date, bookings.booking_status, rooms.room_images, CONCAT(bookings.first_name, ' ', bookings.last_name) as customer_name, bookings.email
        FROM bookings 
        JOIN rooms ON bookings.room_id = rooms.room_id
        WHERE (bookings.booking_id LIKE '%$booking_id%')
        AND (bookings.first_name LIKE '%$user_info%' 
        OR bookings.last_name LIKE '%$user_info%' 
        OR bookings.email LIKE '%$user_info%')";

if ($check_in_date) {
    $sql .= " AND bookings.check_in_date = '$check_in_date'";
}

if ($status) {
    $sql .= " AND bookings.booking_status = '$status'";
}

if ($room_type) {
    $sql .= " AND rooms.room_type = '$room_type'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $room_type = $row['room_type'];
        $images = explode(',', $row['room_images']);
        $image = isset($images[0]) ? '../img/room-image/' . strtolower(str_replace(' ', '-', $room_type)) . '/' . htmlspecialchars(trim($images[0])) : '../img/room-image/default-room.jpg';
        $status_class = strtolower($row["booking_status"]);

        echo "<div class='booking-card'>";
        echo "<img src='" . $image . "' alt='Room Image'>";
        echo "<p><strong>Booking ID:</strong> " . $row["booking_id"] . "</p>";
        echo "<p><strong>Customer Name:</strong> " . $row["customer_name"] . "</p>";
        echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
        echo "<p><strong>Room Type:</strong> " . $room_type . "</p>";
        echo "<p><strong>Check-in Date:</strong> " . $row["check_in_date"] . "</p>";
        echo "<p><strong>Check-out Date:</strong> " . $row["check_out_date"] . "</p>";
        echo "<p><span class='booking-status " . $status_class . "'>" . $row["booking_status"] . "</span></p>";
        echo "<div class='booking-actions'>";
        echo "<a class='modify' href='modify.php?id=" . $row["booking_id"] . "'>Modify</a>";
        if ($status_class !== 'cancelled') {
            echo "<a class='cancel' href='cancel.php?id=" . $row["booking_id"] . "'>Cancel</a>";
        }
        echo "<a class='view-receipt' href='invoice.php?booking_id=" . $row["booking_id"] . "'>View Receipt</a>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>No bookings found</p>";
}

$conn->close();
?>
