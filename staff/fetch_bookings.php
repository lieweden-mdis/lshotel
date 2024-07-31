<?php
// Include the database configuration file
include '../config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetching filters from the request
$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : '';
$user_info = isset($_GET['user_info']) ? $_GET['user_info'] : '';
$check_in_date = isset($_GET['check_in_date']) ? $_GET['check_in_date'] : '';
$booking_status = isset($_GET['booking_status']) ? $_GET['booking_status'] : '';
$room_type = isset($_GET['room_type']) ? $_GET['room_type'] : '';

// Function to parse room features
function parseRoomFeatures($featuresString) {
    $features = [];
    $featuresArray = explode(',', $featuresString);
    $bedKeywords = ['Single Bed', 'Queen Bed', 'King Bed'];
    $smokeKeywords = ['Smoking', 'Non-Smoking'];
    
    foreach ($featuresArray as $feature) {
        $feature = trim($feature);
        if (strpos($feature, 'Bed') !== false) {
            $features['bed_selection'][] = $feature;
        } elseif (in_array($feature, $smokeKeywords)) {
            $features['smoke'][] = $feature;
        } else {
            $features['general_features'][] = $feature;
        }
    }
    return $features;
}

// Check if a single booking_id is requested
if ($booking_id != '' && $user_info == '' && $check_in_date == '' && $booking_status == '' && $room_type == '') {
    $sql = "SELECT bookings.booking_id, bookings.created_at AS booking_date, rooms.room_type, bookings.check_in_date, bookings.check_out_date, bookings.days AS stay_days, bookings.number_of_rooms AS room_quantity, bookings.bed_selection, bookings.smoke, bookings.total_amount, bookings.booking_status, bookings.first_name, bookings.last_name, bookings.email, bookings.phone_number AS phone, bookings.bring_car, bookings.car_plates AS car_plate, bookings.additional_requests, rooms.room_features 
            FROM bookings 
            JOIN rooms ON bookings.room_id = rooms.room_id 
            WHERE bookings.booking_id = '$booking_id'";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();

        // Parse room features
        $features = parseRoomFeatures($booking['room_features']);
        $booking['bed_selection_options'] = $features['bed_selection'] ?? [];
        $booking['smoke_options'] = $features['smoke'] ?? [];
        $booking['general_features'] = $features['general_features'] ?? [];

        header('Content-Type: application/json');
        echo json_encode($booking);
    } else {
        header('Content-Type: application/json');
        echo json_encode([]);
    }
    $conn->close();
    exit();
}

// Building the SQL query for list
$sql = "SELECT bookings.booking_id, bookings.created_at AS booking_date, rooms.room_type, bookings.check_in_date, bookings.check_out_date, bookings.days AS stay_days, bookings.number_of_rooms AS room_quantity, bookings.bed_selection, bookings.smoke, bookings.total_amount, bookings.booking_status, CONCAT(bookings.first_name, ' ', bookings.last_name) AS customer_name, bookings.email, bookings.phone_number AS phone, bookings.bring_car, bookings.car_plates AS car_plate, bookings.additional_requests 
        FROM bookings 
        JOIN rooms ON bookings.room_id = rooms.room_id 
        WHERE 1=1";

if ($booking_id != '') {
    $sql .= " AND bookings.booking_id LIKE '%$booking_id%'";
}
if ($user_info != '') {
    $sql .= " AND (bookings.first_name LIKE '%$user_info%' OR bookings.last_name LIKE '%$user_info%' OR bookings.email LIKE '%$user_info%')";
}
if ($check_in_date != '') {
    $sql .= " AND bookings.check_in_date = '$check_in_date'";
}
if ($booking_status != '') {
    $sql .= " AND bookings.booking_status = '$booking_status'";
}
if ($room_type != '') {
    $sql .= " AND rooms.room_type = '$room_type'";
}

$result = $conn->query($sql);

// Generating HTML table rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status_class = strtolower($row['booking_status']); // Convert status to lowercase for class names
        $bookingData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); // Encode data for use in JavaScript
        echo "<tr>
                <td>{$row['booking_id']}</td>
                <td>{$row['customer_name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['room_type']}</td>
                <td>{$row['check_in_date']}</td>
                <td>{$row['check_out_date']}</td>
                <td><span class='booking-status $status_class'>{$row['booking_status']}</span></td>
                <td class='booking-actions'>
                    <a href='#' class='modify' onclick='fetchBookingDetails({$row['booking_id']})'>Modify</a>";
        
        if ($row['booking_status'] != 'cancelled') {
            echo "<a href='#' class='cancel' onclick='openCancelModal({$row['booking_id']})'>Cancel</a>";
        }
        
        echo "<a href='#' class='view-receipt' onclick='viewReceipt({$row['booking_id']})'>View Receipt</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='8'>No bookings found</td></tr>";
}

$conn->close();
?>
