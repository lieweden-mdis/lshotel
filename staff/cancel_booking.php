<?php
require_once '../config.php'; // Ensure this file includes your database connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $cancel_reason = $_POST['cancel_reason'];
    $number_of_rooms = $_POST['number_of_rooms'];

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Update bookings table to set status to cancelled
        $stmt_update_booking = $conn->prepare("UPDATE bookings SET booking_status = 'cancelled', cancel_reason = ? WHERE booking_id = ?");
        if ($stmt_update_booking) {
            $stmt_update_booking->bind_param('si', $cancel_reason, $booking_id);
            $stmt_update_booking->execute();
            $stmt_update_booking->close();
        } else {
            throw new Exception("Error preparing statement for bookings: " . $conn->error);
        }

        // Get room_id and number_of_rooms from room_assignments
        $stmt_get_rooms = $conn->prepare("SELECT room_id, COUNT(*) AS rooms_booked FROM room_assignments WHERE booking_id = ? AND assign_status != 'cancelled' GROUP BY room_id");
        if ($stmt_get_rooms) {
            $stmt_get_rooms->bind_param('i', $booking_id);
            $stmt_get_rooms->execute();
            $stmt_get_rooms->store_result(); // Store result set
            $stmt_get_rooms->bind_result($room_id, $rooms_booked);

            while ($stmt_get_rooms->fetch()) {
                // Update room_assignments table to reflect cancellation
                $stmt_update_assignments = $conn->prepare("UPDATE room_assignments SET assign_status = 'cancelled' WHERE booking_id = ? AND room_id = ?");
                if ($stmt_update_assignments) {
                    $stmt_update_assignments->bind_param('ii', $booking_id, $room_id);
                    $stmt_update_assignments->execute();
                    $stmt_update_assignments->close();
                } else {
                    throw new Exception("Error preparing statement for room_assignments: " . $conn->error);
                }

                // Update rooms table to increase room availability
                $stmt_update_availability = $conn->prepare("UPDATE rooms SET room_availability = room_availability + ? WHERE room_id = ?");
                if ($stmt_update_availability) {
                    $stmt_update_availability->bind_param('ii', $rooms_booked, $room_id);
                    $stmt_update_availability->execute();
                    $stmt_update_availability->close();
                } else {
                    throw new Exception("Error preparing statement for rooms: " . $conn->error);
                }
            }

            $stmt_get_rooms->close();
        } else {
            throw new Exception("Error preparing statement for fetching rooms: " . $conn->error);
        }

        // Commit transaction
        $conn->commit();

        // Return success message
        echo "Success";
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo $e->getMessage();
    }

    // Close the connection
    $conn->close();
}
?>
