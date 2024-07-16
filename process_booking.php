<?php
session_start();
require 'config.php';

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

// Retrieve form data
$room_type = sanitizeInput($_POST['room_type']);
$check_in_date = sanitizeInput($_POST['check-in-date']);
$check_out_date = sanitizeInput($_POST['check-out-date']);
$days = sanitizeInput($_POST['day']);
$number_of_rooms = sanitizeInput($_POST['room-quantity']);
$bed_selection = sanitizeInput($_POST['bed']);
$smoke = sanitizeInput($_POST['smoke']);
$first_name = sanitizeInput($_POST['fname']);
$last_name = sanitizeInput($_POST['lname']);
$email = sanitizeInput($_POST['email']);
$phone_number = sanitizeInput($_POST['phone']);
$bring_car = sanitizeInput($_POST['car-1']);
$total_amount = sanitizeInput($_POST['total-amount']);
$payment_status = 'pending';

// Debug logs
error_log("Received bed selection: " . $bed_selection);
error_log("Sanitized bed selection: " . $bed_selection);

// Collect car plates
$car_plates = [];
foreach ($_POST as $key => $value) {
    if (strpos($key, 'car_plate_') === 0) {
        $car_plates[] = sanitizeInput($value);
    }
}
$car_plates_string = implode(',', $car_plates);

// Collect additional requests
$additional_requests = [];
for ($i = 1; $i <= $number_of_rooms; $i++) {
    $extra_bed = isset($_POST["add-bed-$i"]) ? sanitizeInput($_POST["add-bed-$i"]) : '';
    $bed_quantity = isset($_POST["bedquantity-$i"]) ? sanitizeInput($_POST["bedquantity-$i"]) : 0;
    $add_breakfast = isset($_POST["add-breakfast-$i"]) ? sanitizeInput($_POST["add-breakfast-$i"]) : '';
    $breakfast_quantity = isset($_POST["breakfastquantity-$i"]) ? sanitizeInput($_POST["breakfastquantity-$i"]) : 0;

    $additional_requests[] = [
        'extra_bed' => $extra_bed,
        'bed_quantity' => $bed_quantity,
        'add_breakfast' => $add_breakfast,
        'breakfast_quantity' => $breakfast_quantity,
    ];
}

$additional_requests_json = json_encode($additional_requests);

// Fetch room id from room type
$sql = "SELECT room_id FROM rooms WHERE room_type = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $room_type);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $room = $result->fetch_assoc();
    $room_id = $room['room_id'];
} else {
    error_log("Error: Room type not found.");
    echo "Error: Room type not found.";
    exit();
}
$stmt->close();

// Debug log before insert
error_log("Prepared to insert: email=$email, room_id=$room_id, check_in_date=$check_in_date, check_out_date=$check_out_date, days=$days, number_of_rooms=$number_of_rooms, bed_selection=$bed_selection, smoke=$smoke, first_name=$first_name, last_name=$last_name, phone_number=$phone_number, bring_car=$bring_car, additional_requests=$additional_requests_json, total_amount=$total_amount, car_plates=$car_plates_string, payment_status=$payment_status");

// Insert booking data into the database
$sql = "INSERT INTO bookings (email, room_id, check_in_date, check_out_date, days, number_of_rooms, bed_selection, smoke, first_name, last_name, phone_number, bring_car, additional_requests, total_amount, car_plates, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sissiisssssssdss', $email, $room_id, $check_in_date, $check_out_date, $days, $number_of_rooms, $bed_selection, $smoke, $first_name, $last_name, $phone_number, $bring_car, $additional_requests_json, $total_amount, $car_plates_string, $payment_status);

// Debug log before execution
error_log("SQL query: " . $sql);
error_log("Bed selection before insert: " . $bed_selection);

if ($stmt->execute()) {
    // Debug log after successful execution
    error_log("Booking inserted successfully. Bed selection: " . $bed_selection);
    
    // Redirect to payment page
    header('Location: payment.php?booking_id=' . $stmt->insert_id);
    exit();
} else {
    // Handle error
    error_log("Error inserting booking: " . $stmt->error);
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
