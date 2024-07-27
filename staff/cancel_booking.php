<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $cancel_reason = $_POST['cancel_reason'];
    $number_of_rooms = $_POST['number_of_rooms'];

    $conn->begin_transaction();

    try {
        $stmt_update_booking = $conn->prepare("UPDATE bookings SET booking_status = 'cancelled', cancel_reason = ? WHERE booking_id = ?");
        if ($stmt_update_booking) {
            $stmt_update_booking->bind_param('si', $cancel_reason, $booking_id);
            $stmt_update_booking->execute();
            $stmt_update_booking->close();
        } else {
            throw new Exception("Error preparing statement for bookings: " . $conn->error);
        }

        // Additional update logic...

        $conn->commit();
        echo "Success";
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }

    $conn->close();
}
?>
