<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../css/staff/staff-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/staff/staff-filters.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/staff/staff-booking-table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/staff/cancel_modal.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/staff/booking_modal.css?v=<?php echo time(); ?>">
    <title>L's HOTEL - ALL BOOKING</title>
    <link rel="icon" href="../img/icon.jpg">
    <style>
        #message {
            display: none;
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
        }
    </style>
</head>
<body>
<div class="staff-container">
    <?php include 'staff_sidenav.php'; ?>

    <div class="main">
        <div class="staff-page-title">
            <span>All Bookings</span>
        </div>

        <!-- Filters -->
        <div class="filters">
            <label>
                Filter by Booking ID
                <input type="text" id="booking-id" placeholder="Booking ID">
            </label>
            <label>
                Filter by User Info
                <input type="text" id="user-info" placeholder="User Info">
            </label>
            <label>
                Check-in Date
                <input type="date" id="check-in-date">
            </label>
            <label>
                Filter by Status
                <select id="booking-status">
                    <option value="">All Statuses</option>
                    <option value="success">Success</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </label>
            <label>
                Filter by Room Type
                <select id="room-type">
                    <option value="">All Room Types</option>
                    <?php
                    include '../config.php';
                    $room_query = "SELECT DISTINCT room_type FROM rooms";
                    $room_result = $conn->query($room_query);

                    if ($room_result->num_rows > 0) {
                        while ($room_row = $room_result->fetch_assoc()) {
                            echo "<option value='{$room_row['room_type']}'>{$room_row['room_type']}</option>";
                        }
                    }
                    ?>
                </select>
            </label>
            <button id="clear-filters-button">Clear Filters</button>
        </div>

        <!-- Booking Table -->
        <div class="booking-table">
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Room Type</th>
                        <th>Check-in Date</th>
                        <th>Check-out Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="booking-rows">
                    <?php
                    $room_type = isset($_GET['room_type']) ? $_GET['room_type'] : '';
                    $booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : '';
                    $user_info = isset($_GET['user_info']) ? $_GET['user_info'] : '';
                    $check_in_date = isset($_GET['check_in_date']) ? $_GET['check_in_date'] : '';
                    $booking_status = isset($_GET['booking_status']) ? $_GET['booking_status'] : '';

                    $query = "SELECT b.booking_id, b.first_name, b.last_name, b.email, b.check_in_date, b.check_out_date, b.booking_status, r.room_type 
                              FROM bookings b 
                              JOIN rooms r ON b.room_id = r.room_id 
                              WHERE 1=1";

                    if (!empty($room_type)) {
                        $query .= " AND r.room_type = '$room_type'";
                    }
                    if (!empty($booking_id)) {
                        $query .= " AND b.booking_id LIKE '%$booking_id%'";
                    }
                    if (!empty($user_info)) {
                        $query .= " AND (b.first_name LIKE '%$user_info%' OR b.last_name LIKE '%$user_info%' OR b.email LIKE '%$user_info%')";
                    }
                    if (!empty($check_in_date)) {
                        $query .= " AND b.check_in_date = '$check_in_date'";
                    }
                    if (!empty($booking_status)) {
                        $query .= " AND b.booking_status = '$booking_status'";
                    }

                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $status_class = strtolower($row['booking_status']); // Convert status to lowercase for class names
                            $customer_name = $row['first_name'] . ' ' . $row['last_name'];
                            $room_type = $row['room_type'];

                            echo "<tr>
                                    <td>{$row['booking_id']}</td>
                                    <td>{$customer_name}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$room_type}</td>
                                    <td>{$row['check_in_date']}</td>
                                    <td>{$row['check_out_date']}</td>
                                    <td><span class='booking-status $status_class'>{$row['booking_status']}</span></td>
                                    <td class='booking-actions'>
                                        <a href='#' class='modify' onclick='fetchBookingDetails({$row['booking_id']})'>Modify</a>";

                            if ($row['booking_status'] != 'cancelled') {
                                echo "<a href='#' class='cancel' onclick='openCancelModal({$row['booking_id']})'>Cancel</a>";
                            }

                            echo "<a href='#' class='view-receipt' onclick='viewReceipt({$row['booking_id']})'>View Receipt</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No bookings found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Message Element -->
<div id="message"></div>

<footer>
    <p>&copy;2024 L's Hotel All Right Reserved.</p>
</footer>

<!-- Include the external modals -->
<?php include 'cancel_modal.php'; ?>
<?php include 'booking_modal.php'; ?>

<!-- Include the external JavaScript file -->
<script src="../script/allbooking.js?v=<?php echo time(); ?>"></script>
</body>
</html>
