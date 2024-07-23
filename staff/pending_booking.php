<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="../css/staff/staff-style.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="../css/staff/pending-booking.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="../css/staff/booking_modal.css?v=<?php echo time(); ?>">
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
    
    <!-- Filter Fields -->
    <div class="filter-container">
      <div>
        <label for="booking_id">Filter by Booking ID</label>
        <input type="text" id="booking_id" placeholder="Booking ID" oninput="filterTable()">
      </div>
      <div>
        <label for="customer_name">Filter by Customer Name</label>
        <input type="text" id="customer_name" placeholder="Customer Name" oninput="filterTable()">
      </div>
      <div>
        <label for="customer_email">Filter by Customer Email</label>
        <input type="text" id="customer_email" placeholder="Customer Email" oninput="filterTable()">
      </div>
      <div>
        <button type="button" class="clear-btn" onclick="clearFilters()">Clear Filters</button>
      </div>
    </div>

    <!-- Pending Booking List -->
    <div class="pending-booking-list">
      <table id="bookingTable">
        <thead>
          <tr>
            <th>Booking ID</th>
            <th>Booking Date</th>
            <th>Customer Name</th>
            <th>Customer Email</th>
            <th>Room Type</th>
            <th>Days of Stay</th>
            <th>Total Amount</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            // Function to safely escape and encode data for JavaScript
            function js_escape($str) {
                return addslashes(htmlspecialchars($str, ENT_QUOTES, 'UTF-8'));
            }

            // Retrieve all bookings with room type and level
            $query = "SELECT 
                        b.booking_id, 
                        DATE_FORMAT(b.created_at, '%d %M %Y') as booking_date,
                        b.check_in_date, 
                        b.check_out_date, 
                        b.days,
                        b.number_of_rooms,
                        b.bed_selection,
                        b.smoke,
                        b.total_amount,
                        b.additional_requests,
                        b.first_name, 
                        b.last_name, 
                        b.email,
                        b.phone_number,
                        b.bring_car,
                        b.car_plates,
                        r.room_type,
                        r.room_features
                      FROM bookings b
                      JOIN rooms r ON b.room_id = r.room_id
                      WHERE b.booking_status = 'pending'";

            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $booking_id = js_escape($row['booking_id']);
                    $booking_date = js_escape($row['booking_date']);
                    $check_in_date = js_escape($row['check_in_date']);
                    $check_out_date = js_escape($row['check_out_date']);
                    $days = js_escape($row['days']);
                    $number_of_rooms = js_escape($row['number_of_rooms']);
                    $bed_selection = js_escape($row['bed_selection']);
                    $smoke = js_escape($row['smoke']);
                    $total_amount = js_escape($row['total_amount']);
                    $additional_requests = js_escape($row['additional_requests']);
                    $first_name = js_escape($row['first_name']);
                    $last_name = js_escape($row['last_name']);
                    $email = js_escape($row['email']);
                    $phone_number = js_escape($row['phone_number']);
                    $bring_car = js_escape($row['bring_car']);
                    $car_plates = js_escape($row['car_plates']);
                    $room_type = js_escape($row['room_type']);
                    $room_features = js_escape($row['room_features']);
                    
                    $name = $row['first_name'] . ' ' . $row['last_name'];
                    echo "<tr>
                            <td>{$booking_id}</td>
                            <td>{$booking_date}</td>
                            <td>{$name}</td>
                            <td>{$email}</td>
                            <td>{$room_type}</td>
                            <td>{$days}</td>
                            <td>RM {$total_amount}</td>
                            <td>
                              <a href='assign_room.php?booking_id={$booking_id}' class='action-btn assign-btn'>Assign Room</a>
                              <button class='action-btn view-btn' onclick=\"openBookingModal('{$booking_id}', '{$booking_date}', '{$check_in_date}', '{$check_out_date}', '{$days}', '{$number_of_rooms}', '{$bed_selection}', '{$smoke}', '{$total_amount}', '{$additional_requests}', '{$first_name}', '{$last_name}', '{$email}', '{$phone_number}', '{$bring_car}', '{$car_plates}', '{$room_type}', '{$room_features}')\">View Details</button>
                              <a href='cancel_booking.php?booking_id={$booking_id}' class='action-btn cancel-btn'>Cancel</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No pending bookings found.</td></tr>";
            }

            $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'booking_modal.php'; ?>

<footer>
  <p>&copy;2024 L's Hotel All Right Reserved.</p>
</footer>

<script src="../script/booking_modal.js?v=<?php echo time(); ?>"></script>
<script src="../script/filter.js?v=<?php echo time(); ?>"></script>
</body>
</html>
