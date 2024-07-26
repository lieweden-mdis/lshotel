<?php
// Example PHP code to update booking details

// Get the booking ID
$booking_id = $_GET['booking_id'];

// Get the JSON data from the request body
$data = json_decode(file_get_contents('php://input'), true);

// Database connection
$conn = new mysqli('localhost', 'username', 'password', 'database');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("UPDATE bookings SET bed_selection=?, smoke=?, customer_name=?, email=?, phone=?, bring_car=?, car_plate=? WHERE booking_id=?");
$stmt->bind_param("sssssssi", $bed_selection, $smoke, $customer_name, $email, $phone, $bring_car, $car_plate, $booking_id);

// Set parameters and execute
$bed_selection = $data['bed_selection'];
$smoke = $data['smoke'];
$customer_name = $data['customer_name'];
$email = $data['email'];
$phone = $data['phone'];
$bring_car = $data['bring_car'];
$car_plate = $data['car_plate'];

if ($stmt->execute()) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false, "error" => $stmt->error));
}

$stmt->close();
$conn->close();
?>
