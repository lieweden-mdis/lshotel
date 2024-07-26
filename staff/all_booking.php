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

<!-- Include the external JavaScript files -->
<script src="../script/allbooking.js"></script>
<script src="../script/booking_modal.js"></script>
</body>
</html>
