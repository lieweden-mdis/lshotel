<?php
include '../config.php';

function js_escape($str) {
    return addslashes(htmlspecialchars($str, ENT_QUOTES, 'UTF-8'));
}

$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

$bookings_query = "SELECT 
                    b.booking_id, 
                    DATE_FORMAT(b.created_at, '%d/%m/%Y') as booking_date,
                    b.check_in_date, 
                    b.check_out_date, 
                    b.first_name, 
                    b.last_name, 
                    b.email,
                    b.number_of_rooms,
                    r.room_type,
                    r.room_level
                  FROM bookings b
                  JOIN rooms r ON b.room_id = r.room_id
                  WHERE b.booking_status = 'pending'";

$bookings_result = $conn->query($bookings_query);

$rooms_query = "SELECT room_id, room_type, room_level, room_number, assign_status 
                FROM room_assignments 
                WHERE assign_status = 'Not Assign'";
$rooms_result = $conn->query($rooms_query);
$rooms = [];
if ($rooms_result->num_rows > 0) {
    while ($room = $rooms_result->fetch_assoc()) {
        $rooms[] = $room;
    }
}

$rooms_json = json_encode($rooms);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../css/staff/staff-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/staff/pending-booking.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/staff/room_assign.css?v=<?php echo time(); ?>">
    <title>L's HOTEL - PENDING BOOKING</title>
    <link rel="icon" href="../img/icon.jpg">
</head>
<body>
<div class="staff-container">
    <?php include 'staff_sidenav.php'; ?>
    <div class="main">
        <div class="staff-page-title">
            <span>Pending Booking</span>
        </div>

        <div id="successMessage" class="success-message" style="display: none;">
            Rooms assigned successfully.
        </div>

        <!-- Filter Fields -->
        <div class="filters">
            <label>
                Filter by Booking ID
                <input type="text" id="booking_id" placeholder="Booking ID">
            </label>
            <label>
                Filter by Name
                <input type="text" id="customer_name" placeholder="Name">
            </label>
            <label>
                Filter by Customer Email
                <input type="text" id="customer_email" placeholder="Customer Email">
            </label>
            <button type="button" onclick="clearFilters()">Clear Filters</button>
        </div>

        <!-- Pending Booking List -->
        <div class="table-wrapper">
            <table class="table table-striped" id="bookingTable">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Booking Date</th>
                        <th>Name</th>
                        <th>Customer Email</th>
                        <th>Room Type</th>
                        <th>Room Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="bookingTableBody">
                    <?php
                    if ($bookings_result->num_rows > 0) {
                        while($row = $bookings_result->fetch_assoc()) {
                            $booking_id = js_escape($row['booking_id']);
                            $number_of_rooms = js_escape($row['number_of_rooms']);
                            $booking_date = js_escape($row['booking_date']);
                            $check_in_date = js_escape($row['check_in_date']);
                            $check_out_date = js_escape($row['check_out_date']);
                            $name = js_escape($row['first_name'] . ' ' . $row['last_name']);
                            $email = js_escape($row['email']);
                            $room_type = js_escape($row['room_type']);
                            $room_level = js_escape($row['room_level']);

                            echo "<tr>
                                    <td>{$booking_id}</td>
                                    <td>{$booking_date}</td>
                                    <td>{$name}</td>
                                    <td>{$email}</td>
                                    <td>{$room_type}</td>
                                    <td>{$number_of_rooms}</td>
                                    <td class='action-buttons'>
                                        <button class='btn btn-primary' onclick='openAssignRoomModal({$booking_id}, \"{$booking_date}\", \"{$check_in_date}\", \"{$check_out_date}\", \"{$name}\", \"{$email}\", \"{$room_type}\", {$number_of_rooms}, \"{$room_level}\")'>Assign Room</button>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No pending bookings found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Assign Room Form -->
<div id="assignRoomModal" class="assign-room-modal" style="display: none;">
    <div class="assign-room-modal-content">
        <span class="assign-room-close" onclick="closeAssignRoomModal()">&times;</span>
        <h2>Assign Room</h2>
        <form method="post" action="assign_room_action.php">
            <div class="assign-room-modal-section">
                <h3>Booking Info</h3>
                <div class="assign-room-form-row">
                    <div>
                        <label>Booking ID</label>
                        <input type="text" id="modalBookingIdText" name="booking_id" readonly>
                    </div>
                    <div>
                        <label>Booking Date</label>
                        <input type="text" id="modalBookingDate" readonly>
                    </div>
                </div>
                <div class="assign-room-form-row">
                    <div>
                        <label>Check In Date</label>
                        <input type="text" id="modalCheckInDate" readonly>
                    </div>
                    <div>
                        <label>Check Out Date</label>
                        <input type="text" id="modalCheckOutDate" readonly>
                    </div>
                </div>
                <div class="assign-room-form-row">
                    <div>
                        <label>Name</label>
                        <input type="text" id="modalCustomerName" readonly>
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="text" id="modalCustomerEmail" readonly>
                    </div>
                </div>
            </div>
            <hr>
            <div class="assign-room-modal-section">
                <h3>Room Info</h3>
                <div class="assign-room-form-row">
                    <div>
                        <label>Room Type</label>
                        <input type="text" id="modalRoomType" readonly>
                    </div>
                    <div>
                        <label>Room Level</label>
                        <input type="text" id="modalRoomLevel" readonly>
                    </div>
                </div>
            </div>
            <hr>
            <div class="assign-room-modal-section">
                <h3>List of Rooms</h3>
                <div id="roomsContainer" class="assign-room-rooms-grid">
                    <!-- Room assignment fields will be dynamically generated here -->
                </div>
            </div>
            <div class="assign-room-modal-actions">
                <button type="submit" name="assignRooms" class="assign-room-button assign-room-btn-primary">Assign</button>
                <button type="button" class="assign-room-button assign-room-btn-secondary" onclick="closeAssignRoomModal()">Exit</button>
            </div>
        </form>
    </div>
</div>

<footer>
    <p>&copy;2024 L's Hotel All Right Reserved.</p>
</footer>

<script src="../script/pending_booking.js?v=<?php echo time(); ?>"></script>
</body>
</html>
