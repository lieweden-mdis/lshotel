<?php
include '../config.php';

$response = [];

// Room Availability
$room_types = ['Standard Room', 'Deluxe Room', 'Triple Room', 'Family Suite Room'];
$room_availability = [];
foreach ($room_types as $room_type) {
    $sql = "SELECT room_availability FROM rooms WHERE room_type='$room_type'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $room_availability[$room_type] = $row['room_availability'];
    }
}
$response['room_availability'] = $room_availability;

// Booking Overview
$sql = "SELECT COUNT(*) AS total_bookings FROM bookings";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$response['total_bookings'] = $row['total_bookings'];

$sql = "SELECT COUNT(*) AS completed_bookings FROM bookings WHERE booking_status='Complete'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$response['completed_bookings'] = $row['completed_bookings'];

$sql = "SELECT COUNT(*) AS pending_bookings FROM bookings WHERE booking_status='Pending'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$response['pending_bookings'] = $row['pending_bookings'];

$sql = "SELECT COUNT(*) AS cancelled_bookings FROM bookings WHERE booking_status='Cancelled'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$response['cancelled_bookings'] = $row['cancelled_bookings'];

// Recent Booking
$sql = "SELECT bookings.booking_id, CONCAT(bookings.first_name, ' ', bookings.last_name) AS customer_name, rooms.room_type, bookings.check_in_date, bookings.check_out_date, bookings.number_of_rooms 
        FROM bookings 
        JOIN rooms ON bookings.room_id = rooms.room_id 
        ORDER BY bookings.created_at DESC LIMIT 5";
$result = $conn->query($sql);
$recent_bookings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recent_bookings[] = $row;
    }
}
$response['recent_bookings'] = $recent_bookings;

$conn->close();
echo json_encode($response);
?>
