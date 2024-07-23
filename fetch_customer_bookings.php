<?php
include 'config.php';

// Check if a session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the email is set in the session
if (!isset($_SESSION['user']['email'])) {
    echo "Please log in to view your bookings.";
    exit;
}

$email = $_SESSION['user']['email'];

$sql = "SELECT bookings.booking_id, bookings.created_at, rooms.room_type, bookings.check_in_date, bookings.check_out_date, bookings.days, bookings.number_of_rooms, bookings.bed_selection, bookings.smoke, CONCAT(bookings.first_name, ' ', bookings.last_name) as customer_name, bookings.email, bookings.phone_number, bookings.bring_car, bookings.car_plates, bookings.booking_status, bookings.additional_requests, bookings.total_amount, rooms.room_images
        FROM bookings 
        JOIN rooms ON bookings.room_id = rooms.room_id
        WHERE bookings.email = '$email'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $room_type = $row['room_type'];
        $images = explode(',', $row['room_images']);
        $image = isset($images[0]) ? 'img/room-image/' . strtolower(str_replace(' ', '-', $room_type)) . '/' . htmlspecialchars(trim($images[0])) : 'img/room-image/default-room.jpg';
        $status_class = strtolower($row["booking_status"]);

        // Parse the additional_requests JSON string
        $additional_requests = json_decode($row['additional_requests'], true);
        $additional_charges = [];
        foreach ($additional_requests as $request) {
            $additional_charges[] = [
                "extraBed" => $request['extra_bed'],
                "extraBedQuantity" => $request['bed_quantity'],
                "addBreakfast" => $request['add_breakfast'],
                "breakfastQuantity" => $request['breakfast_quantity']
            ];
        }

        $booking_data = json_encode([
            "bookingId" => $row["booking_id"],
            "bookingDate" => substr($row["created_at"], 0, 10),
            "roomType" => $row["room_type"],
            "checkInDate" => $row["check_in_date"],
            "checkOutDate" => $row["check_out_date"],
            "stayDays" => $row["days"],
            "roomQuantity" => $row["number_of_rooms"],
            "bedSelection" => $row["bed_selection"],
            "smoke" => $row["smoke"],
            "totalAmount" => $row["total_amount"],
            "customerName" => $row["customer_name"],
            "email" => $row["email"],
            "phone" => $row["phone_number"],
            "bringCar" => $row["bring_car"],
            "carPlate" => $row["car_plates"],
            "additionalCharges" => $additional_charges
        ]);

        echo "<div class='booking-card'>";
        echo "<img src='" . $image . "' alt='Room Image'>";
        echo "<p><strong>Booking ID:</strong> " . $row["booking_id"] . "</p>";
        echo "<p><strong>Room Type:</strong> " . $room_type . "</p>";
        echo "<p><strong>Check-in Date:</strong> " . $row["check_in_date"] . "</p>";
        echo "<p><strong>Check-out Date:</strong> " . $row["check_out_date"] . "</p>";
        echo "<p><strong>Total Amount Paid:</strong> RM " . $row["total_amount"] . "</p>";
        echo "<p><span class='booking-status " . $status_class . "'>" . $row["booking_status"] . "</span></p>";
        echo "<div class='booking-actions'>";
        echo "<a class='view-details' href='javascript:void(0);' data-booking-data='" . htmlspecialchars($booking_data, ENT_QUOTES, 'UTF-8') . "'>View Details</a>";
        echo "<a class='view-receipt' href='invoice.php?booking_id=" . $row["booking_id"] . "'>View Receipt</a>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>No bookings found</p>";
}

$conn->close();
?>
