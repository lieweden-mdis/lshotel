<?php
function getPendingBookingCount($conn) {
    $sql = "SELECT COUNT(*) as count FROM bookings WHERE status = 'pending'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else {
        return 0;
    }
}
?>