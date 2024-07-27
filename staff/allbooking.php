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
    float: right;
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
          <option value="Standard Room">Standard Room</option>
          <option value="Deluxe Room">Deluxe Room</option>
          <option value="Triple Room">Triple Room</option>
          <option value="Family Suite Room">Family Suite Room</option>
        </select>
      </label>
      <button id="clear-filters-button" type="button" onclick="clearFilters()">Clear Filters</button>
    </div>

    <!-- Fetch and display booking data -->
    <div id="message">Booking updated successfully</div>
    <div id="booking-table" class="booking-table">
      <table>
        <thead>
          <tr>
            <th>Booking ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Room Type</th>
            <th>Check-in Date</th>
            <th>Check-out Date</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="booking-rows">
          <!-- Booking rows will be dynamically inserted here -->
          <?php
          // Include the database configuration file
          include '../config.php';

          // Check connection
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          // Fetching filters from the request
          $booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : '';
          $user_info = isset($_GET['user_info']) ? $_GET['user_info'] : '';
          $check_in_date = isset($_GET['check_in_date']) ? $_GET['check_in_date'] : '';
          $status = isset($_GET['status']) ? $_GET['status'] : '';
          $room_type = isset($_GET['room_type']) ? $_GET['room_type'] : '';

          // Building the SQL query for list
          $sql = "SELECT bookings.booking_id, bookings.created_at AS booking_date, rooms.room_type, bookings.check_in_date, bookings.check_out_date, bookings.days AS stay_days, bookings.number_of_rooms AS room_quantity, bookings.bed_selection, bookings.smoke, bookings.total_amount, bookings.booking_status, CONCAT(bookings.first_name, ' ', bookings.last_name) AS customer_name, bookings.email, bookings.phone_number AS phone, bookings.bring_car, bookings.car_plates AS car_plate, bookings.additional_requests 
                  FROM bookings 
                  JOIN rooms ON bookings.room_id = rooms.room_id 
                  WHERE 1=1";

          if ($booking_id != '') {
              $sql .= " AND bookings.booking_id LIKE '%$booking_id%'";
          }
          if ($user_info != '') {
              $sql .= " AND (bookings.first_name LIKE '%$user_info%' OR bookings.last_name LIKE '%$user_info%' OR bookings.email LIKE '%$user_info%')";
          }
          if ($check_in_date != '') {
              $sql .= " AND bookings.check_in_date = '$check_in_date'";
          }
          if ($status != '') {
              $sql .= " AND bookings.booking_status = '$status'";
          }
          if ($room_type != '') {
              $sql .= " AND rooms.room_type = '$room_type'";
          }

          $result = $conn->query($sql);

          // Generating HTML table rows
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $status_class = strtolower($row['booking_status']); // Convert status to lowercase for class names
                  $bookingData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); // Encode data for use in JavaScript
                  echo "<tr>
                          <td>{$row['booking_id']}</td>
                          <td>{$row['customer_name']}</td>
                          <td>{$row['email']}</td>
                          <td>{$row['room_type']}</td>
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
