<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="../css/staff/staff-style.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="../css/staff/staff-filters.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="../css/staff/staff-booking-cards.css?v=<?php echo time(); ?>">
<title>L's HOTEL - STAFF PROFILE</title>
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
      <button type="button" onclick="clearFilters()">Clear Filters</button>
    </div>

    <!-- Fetch and display booking data -->
    <div id="booking-cards" class="booking-cards">
      <!-- Booking cards will be dynamically inserted here -->
    </div>
  </div>
</div>
<footer>
  <p>&copy;2024 L's Hotel All Right Reserved.</p>
</footer>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const fetchBookings = () => {
    const params = new URLSearchParams({
      booking_id: document.getElementById('booking-id').value,
      user_info: document.getElementById('user-info').value,
      check_in_date: document.getElementById('check-in-date').value,
      status: document.getElementById('booking-status').value,
      room_type: document.getElementById('room-type').value,
    });

    fetch(`fetch_bookings.php?${params.toString()}`)
      .then(response => response.text())
      .then(data => document.getElementById('booking-cards').innerHTML = data)
      .catch(error => console.error('Error fetching bookings:', error));
  };

  const clearFilters = () => {
    document.getElementById('booking-id').value = '';
    document.getElementById('user-info').value = '';
    document.getElementById('check-in-date').value = '';
    document.getElementById('booking-status').value = '';
    document.getElementById('room-type').value = '';
    fetchBookings();
  };

  document.getElementById('booking-id').addEventListener('keyup', fetchBookings);
  document.getElementById('user-info').addEventListener('keyup', fetchBookings);
  document.getElementById('check-in-date').addEventListener('change', fetchBookings);
  document.getElementById('booking-status').addEventListener('change', fetchBookings);
  document.getElementById('room-type').addEventListener('change', fetchBookings);

  fetchBookings();
});
</script>
<script src="../script/staff.js"></script>
</body>
</html>
