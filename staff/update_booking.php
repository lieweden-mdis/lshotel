<?php
include '../config.php'; // Include your database connection file

$booking_id = $_POST['booking_id'];
$check_in_date = $_POST['check_in_date'];
$check_out_date = $_POST['check_out_date'];
$days = $_POST['days'];
$bed_selection = $_POST['bed_selection'];
$smoke = $_POST['smoke'];
$customer_name = $_POST['customer_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$bring_car = $_POST['bring_car'];
$car_plate = $_POST['car_plate'];

$query = "UPDATE bookings SET
    check_in_date = '$check_in_date',
    check_out_date = '$check_out_date',
    days = '$days',
    bed_selection = '$bed_selection',
    smoke = '$smoke',
    first_name = SUBSTRING_INDEX('$customer_name', ' ', 1),
    last_name = SUBSTRING_INDEX('$customer_name', ' ', -1),
    email = '$email',
    phone_number = '$phone',
    bring_car = '$bring_car',
    car_plates = '$car_plate'
    WHERE booking_id = '$booking_id'";

if ($conn->query($query) === TRUE) {
    echo "Booking updated successfully";
} else {
    echo "Error updating booking: " . $conn->error;
}

$conn->close();
?>
