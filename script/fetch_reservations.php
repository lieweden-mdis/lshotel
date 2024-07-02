<?php
session_start(); // Start session if not already started

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if email parameter is provided
if (!isset($_GET['email'])) {
    die(json_encode(array("error" => "Email parameter is missing.")));
}

$user_email = $_GET['email'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(array("error" => "Connection failed: " . $conn->connect_error)));
}

// Prepare SQL statement with parameterized query to prevent SQL injection
$sql = "SELECT reservation_id, check_in_date, check_out_date, number_of_guests, room_level, room_number, reservation_status 
        FROM reservation 
        WHERE email = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die(json_encode(array("error" => "Prepare failed: " . $conn->error)));
}

// Bind the email parameter to the prepared statement
$stmt->bind_param("s", $user_email);

if (!$stmt->execute()) {
    die(json_encode(array("error" => "Execute failed: " . $stmt->error)));
}

$result = $stmt->get_result();

$reservations = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
} else {
    // No reservations found, return an empty array
    echo json_encode($reservations); // This will output [] when no reservations found
    $stmt->close();
    $conn->close();
    exit();
}

$stmt->close();
$conn->close();

echo json_encode($reservations);
?>
