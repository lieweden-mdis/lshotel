<?php
// Include the database configuration file
include '../config.php';

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Check if the necessary data is provided
if (!isset($data['booking_id'])) {
    die('Error: Booking ID is missing.');
}

$booking_id = $data['booking_id'];
$first_name = $data['first_name'];
$last_name = $data['last_name'];
$email = $data['email'];
$phone = $data['phone'];
$bring_car = $data['bring_car'];
$car_plate = $data['car_plate'];
$bed_selection = $data['bed_selection'];
$smoke = $data['smoke'];

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$stmt = $conn->prepare("UPDATE bookings SET first_name = ?, last_name = ?, email = ?, phone_number = ?, bring_car = ?, car_plates = ?, bed_selection = ?, smoke = ? WHERE booking_id = ?");
$stmt->bind_param('ssssssssi', $first_name, $last_name, $email, $phone, $bring_car, $car_plate, $bed_selection, $smoke, $booking_id);

// Execute the statement
if ($stmt->execute()) {
    echo 'Success';
} else {
    echo 'Error: ' . $stmt->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>
