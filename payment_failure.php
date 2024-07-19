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
    // Prepare the SQL statement to update the payment status
    $stmt = $conn->prepare("UPDATE bookings SET payment_status = 'fail' WHERE booking_id = ?");
    
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

    // Confirm the payment status update
    $update_fail = true;
    
    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Catch and display any errors
    die("Error updating record: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Failed</title>
    <link rel="icon" href="img/icon.jpg" >
    <link rel="stylesheet" href="css/payment_result.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="message payment-failure">
        <h1>Payment Failed</h1>
        <p>Unfortunately, your payment could not be processed. Please try again.</p>
        <a href="payment.php?booking_id=<?php echo $_GET['booking_id']; ?>"><button>Try Again</button></a>
    </div>
</body>
</html>
