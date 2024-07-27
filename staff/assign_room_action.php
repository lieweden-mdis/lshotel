<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assignRooms'])) {
    $booking_id = $_POST['booking_id'];
    $room_assignments = $_POST['room_assignments'];

    $assign_success = true;

    // Start a transaction
    $conn->begin_transaction();

    try {
        foreach ($room_assignments as $room_number) {
            // Update room_assignments table
            $update_query = "UPDATE room_assignments SET assign_status = 'Assign', booking_id = ? WHERE room_number = ? AND assign_status = 'Not Assign'";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("is", $booking_id, $room_number);
            if (!$stmt->execute()) {
                throw new Exception("Failed to assign room $room_number.");
            }
        }

        // Update bookings table
        $update_booking_query = "UPDATE bookings SET booking_status = 'Success' WHERE booking_id = ?";
        $stmt = $conn->prepare($update_booking_query);
        $stmt->bind_param("i", $booking_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update booking status.");
        }

        // Commit the transaction
        $conn->commit();
        $message = "Rooms assigned successfully.";
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        $assign_success = false;
        $message = "Failed to assign rooms: " . $e->getMessage();
    }
}

// Redirect back to the pending booking page with a success or error message
header("Location: pending_booking.php?message=" . urlencode($message));
exit;
?>
