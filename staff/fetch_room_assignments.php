<?php
include '../config.php';

$booking_id = $_GET['booking_id'];

$query = "SELECT room_level, room_number, extra_bed, breakfast FROM room_assignments WHERE booking_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

$room_assignments = [];
while ($row = $result->fetch_assoc()) {
    $room_assignments[] = $row;
}

echo json_encode($room_assignments);
?>
