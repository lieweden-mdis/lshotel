<?php
include '../config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get data from POST request
$booking_id = $_POST['cancel-booking-id'];
$cancel_reason = $_POST['cancel_reason'];

if (!$booking_id) {
    echo "Error: Booking ID is missing.";
    exit;
}

// Begin transaction
$conn->begin_transaction();

try {
    // Update booking status
    $updateBookingStatus = "UPDATE bookings SET booking_status = 'Cancelled', cancel_reason = ? WHERE booking_id = ?";
    $stmt = $conn->prepare($updateBookingStatus);
    $stmt->bind_param("si", $cancel_reason, $booking_id);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        throw new Exception("Failed to update booking status.");
    }

    // Update room availability in room_assignments
    $updateRoomAssignments = "UPDATE room_assignments SET assign_status = 'Cancelled' WHERE booking_id = ?";
    $stmt = $conn->prepare($updateRoomAssignments);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        throw new Exception("Failed to update room assignments.");
    }

    // Increment the room availability in the rooms table
    $incrementRoomAvailability = "UPDATE rooms SET room_availability = room_availability + (SELECT number_of_rooms FROM bookings WHERE booking_id = ?) WHERE room_id IN (SELECT room_id FROM bookings WHERE booking_id = ?)";
    $stmt = $conn->prepare($incrementRoomAvailability);
    $stmt->bind_param("ii", $booking_id, $booking_id);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        throw new Exception("Failed to increment room availability.");
    }

    // Commit transaction
    $conn->commit();
    echo "Success";
} catch (Exception $e) {
    // Rollback transaction
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
