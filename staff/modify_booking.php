<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $room_numbers = [];
    $extra_beds = [];
    $breakfasts = [];
    
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'room_number_') === 0) {
            $room_numbers[] = $value;
        } elseif (strpos($key, 'extra_bed_') === 0) {
            $extra_beds[] = $value;
        } elseif (strpos($key, 'breakfast_') === 0) {
            $breakfasts[] = $value;
        }
    }

    // Update room assignments
    $delete_query = "DELETE FROM room_assignments WHERE booking_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $booking_id);
    $delete_stmt->execute();

    $insert_query = "INSERT INTO room_assignments (booking_id, room_level, room_number, extra_bed, breakfast) VALUES (?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);

    foreach ($room_numbers as $index => $room_number) {
        $extra_bed = $extra_beds[$index];
        $breakfast = $breakfasts[$index];
        $room_level = (int) ($room_number / 100);
        $insert_stmt->bind_param("iisii", $booking_id, $room_level, $room_number, $extra_bed, $breakfast);
        $insert_stmt->execute();
    }

    // Update booking status to 'Success'
    $update_query = "UPDATE bookings SET booking_status = 'Success' WHERE booking_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("i", $booking_id);
    $update_stmt->execute();

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
