<?php
// Include the config file to set up the database connection
include 'config.php';

// Ensure booking_id is set and retrieved from GET request (URL parameter)
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];
} else {
    die('Booking ID is not set.');
}

try {
    // Begin a transaction
    $conn->begin_transaction();

    // Prepare the SQL statement to update the payment status and booking status
    $stmt = $conn->prepare("UPDATE bookings SET payment_status = 'Success', booking_status = 'Pending' WHERE booking_id = ?");
    
    // Check if the statement was prepared correctly
    if ($stmt === false) {
        throw new Exception('Statement preparation failed: ' . $conn->error);
    }
    
    // Bind the booking_id parameter to the SQL query
    $stmt->bind_param("i", $booking_id);
    
    // Execute the SQL query
    if (!$stmt->execute()) {
        throw new Exception('Statement execution failed: ' . $stmt->error);
    }

    // Close the statement
    $stmt->close();

    // Retrieve the room_id and number of rooms booked associated with the booking
    $stmt = $conn->prepare("SELECT room_id, number_of_rooms FROM bookings WHERE booking_id = ?");
    if ($stmt === false) {
        throw new Exception('Statement preparation failed: ' . $conn->error);
    }

    $stmt->bind_param("i", $booking_id);
    if (!$stmt->execute()) {
        throw new Exception('Statement execution failed: ' . $stmt->error);
    }

    $stmt->bind_result($room_id, $number_of_rooms);
    $stmt->fetch();
    $stmt->close();

    // Update the room availability
    $stmt = $conn->prepare("UPDATE rooms SET room_availability = room_availability - ? WHERE room_id = ?");
    if ($stmt === false) {
        throw new Exception('Statement preparation failed: ' . $conn->error);
    }

    $stmt->bind_param("ii", $number_of_rooms, $room_id);
    if (!$stmt->execute()) {
        throw new Exception('Statement execution failed: ' . $stmt->error);
    }

    // Commit the transaction
    $conn->commit();

    // Close the statement and database connection
    $stmt->close();
    $conn->close();

    // Confirm the payment status update
    $update_success = true;
} catch (Exception $e) {
    // Rollback the transaction in case of an error
    $conn->rollback();
    
    // Catch and display any errors
    die("Error updating record: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>
    <link rel="icon" href="img/icon.jpg">
    <link rel="stylesheet" href="css/payment_result.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="message payment-success">
        <h1>Payment Success</h1>
        <p>Your payment was successful. Thank you!</p>
        <a href="index.php"><button>Go to Homepage</button></a>
    </div>
</body>
</html>
