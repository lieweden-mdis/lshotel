<?php
include '../config.php';

$data = json_decode(file_get_contents('php://input'), true);
$booking_id = $data['booking_id'];
$room_assignments = $data['room_assignments'];

$success = true;

foreach ($room_assignments as $assignment) {
    $room_number = $assignment['roomNumber'];
    
    // Update the room status to 'assigned'
    $update_room_query = "UPDATE room_assignments SET assign_status = 'Assign', booking_id = '$booking_id' WHERE room_number = '$room_number'";
    if (!$conn->query($update_room_query)) {
        $success = false;
        break;
    }
}

// Update booking status to 'assigned' if all room assignments were successful
if ($success) {
    $update_booking_query = "UPDATE bookings SET booking_status = 'Success' WHERE booking_id = '$booking_id'";
    $success = $conn->query($update_booking_query);
}

$response = ['success' => $success];
echo json_encode($response);

$conn->close();
?>
