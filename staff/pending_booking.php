<?php include 'staff_header.php'; ?>
<?php include '../config.php'; // Include your database connection file ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="../css/staff/staff-style.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="../css/staff/pending-booking.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="../css/staff/modal.css?v=<?php echo time(); ?>">
<title>L's HOTEL - PENDING BOOKING</title>
<link rel="icon" href="../img/icon.jpg">
<style>
/* Grid Layout for Booking Details */
.booking-details, .guest-details {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 20px;
}

.booking-details div, .guest-details div {
  background-color: #f4f4f4;
  padding: 10px;
  border-radius: 4px;
}

.room-list {
  margin-bottom: 20px;
}

.room-list h3 {
  margin-bottom: 10px;
}

.room-item {
  background-color: #f4f4f4;
  padding: 10px;
  margin-bottom: 10px;
  border-radius: 4px;
}

.room-item p {
  margin: 5px 0;
}

/* Action Buttons */
.action-btn {
    padding: 8px 12px;
    margin-right: 5px;
    text-decoration: none;
    color: white;
    border-radius: 4px;
    font-size: 14px;
}

.modify-btn {
    background-color: #4CAF50; /* Green */
}

.modify-btn:hover {
    background-color: #45a049;
}

.cancel-btn {
    background-color: #f44336; /* Red */
}

.cancel-btn:hover {
    background-color: #da190b;
}

/* Modal styles */
.modal {
  display: none; 
  position: fixed; 
  z-index: 1; 
  padding-top: 100px; 
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%; 
  overflow: auto; 
  background-color: rgb(0,0,0); 
  background-color: rgba(0,0,0,0.4); 
}

.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%; 
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
</style>
</head>
<body>
<div class="staff-container">
  <?php include 'staff_sidenav.php'; ?>
  <div class="main">
    <div class="staff-page-title">
      <span>Pending Booking</span>
    </div>
    
    <!-- Pending Booking List -->
    <div class="pending-booking-list">
      <table>
        <thead>
          <tr>
            <th>Booking ID</th>
            <th>Booking Date</th>
            <th>Room Type</th>
            <th>Check In Date</th>
            <th>Check Out Date</th>
            <th>Days</th>
            <th>Bed Selection</th>
            <th>Smoke</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            // Retrieve all bookings with room type and level
            $query = "SELECT 
                        b.booking_id, 
                        b.created_at,
                        b.room_id, 
                        r.room_type,
                        r.room_level,
                        b.check_in_date, 
                        b.check_out_date, 
                        b.days,
                        b.bed_selection, 
                        b.smoke, 
                        b.first_name, 
                        b.last_name, 
                        b.email, 
                        b.phone_number, 
                        b.car_plates,
                        b.number_of_rooms
                      FROM bookings b
                      JOIN rooms r ON b.room_id = r.room_id
                      WHERE b.booking_status = 'pending'";

            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $booking_id = $row['booking_id'];
                    $room_type = $row['room_type'];
                    $room_level = $row['room_level'];
                    $number_of_rooms = $row['number_of_rooms'];
                    echo "<tr>
                            <td>{$booking_id}</td>
                            <td>{$row['created_at']}</td>
                            <td>{$room_type}</td>
                            <td>{$row['check_in_date']}</td>
                            <td>{$row['check_out_date']}</td>
                            <td>{$row['days']}</td>
                            <td>{$row['bed_selection']}</td>
                            <td>{$row['smoke']}</td>
                            <td>
                              <button onclick=\"openModal('{$booking_id}', '{$room_type}', '{$room_level}', '{$row['created_at']}', '{$row['check_in_date']}', '{$row['check_out_date']}', '{$row['days']}', '{$row['bed_selection']}', '{$row['smoke']}', '{$row['first_name']}', '{$row['last_name']}', '{$row['email']}', '{$row['phone_number']}', '{$row['car_plates']}', '{$number_of_rooms}')\" class='action-btn modify-btn'>Modify</button>
                              <a href='cancel_booking.php?booking_id={$booking_id}' class='action-btn cancel-btn'>Cancel</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No pending bookings found.</td></tr>";
            }

            $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Modify Booking</h2>
    <form id="modifyForm" method="POST" action="modify_booking.php">
      <input type="hidden" name="booking_id" id="booking_id">
      
      <h3>Booking Information</h3>
      <div class="booking-details">
        <div>
          <label for="booking_date">Booking Date:</label>
          <input type="text" id="booking_date" name="booking_date" readonly>
        </div>
        <div>
          <label for="room_type">Room Type:</label>
          <input type="text" id="room_type" name="room_type" readonly>
        </div>
        <div>
          <label for="check_in_date">Check In Date:</label>
          <input type="text" id="check_in_date" name="check_in_date" readonly>
        </div>
        <div>
          <label for="check_out_date">Check Out Date:</label>
          <input type="text" id="check_out_date" name="check_out_date" readonly>
        </div>
        <div>
          <label for="days">Days:</label>
          <input type="text" id="days" name="days" readonly>
        </div>
        <div>
          <label for="bed_selection">Bed Selection:</label>
          <input type="text" id="bed_selection" name="bed_selection" readonly>
        </div>
        <div>
          <label for="smoke">Smoke:</label>
          <input type="text" id="smoke" name="smoke" readonly>
        </div>
      </div>

      <h3>Guest Information</h3>
      <div class="guest-details">
        <div>
          <label for="first_name">First Name:</label>
          <input type="text" id="first_name" name="first_name" readonly>
        </div>
        <div>
          <label for="last_name">Last Name:</label>
          <input type="text" id="last_name" name="last_name" readonly>
        </div>
        <div>
          <label for="email">Email:</label>
          <input type="text" id="email" name="email" readonly>
        </div>
        <div>
          <label for="phone_number">Phone Number:</label>
          <input type="text" id="phone_number" name="phone_number" readonly>
        </div>
        <div>
          <label for="car_plates">Car Plate Number:</label>
          <input type="text" id="car_plates" name="car_plates" readonly>
        </div>
      </div>

      <h3>List of Rooms</h3>
      <div id="room-list">
        <!-- Dynamic room list will be added here by JavaScript -->
      </div>

      <div>
        <button type="submit" class="action-btn modify-btn">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<footer>
  <p>&copy;2024 L's Hotel All Right Reserved.</p>
</footer>
<script>
// Function to open the modal
function openModal(booking_id, room_type, room_level, booking_date, check_in_date, check_out_date, days, bed_selection, smoke, first_name, last_name, email, phone_number, car_plates, number_of_rooms) {
  document.getElementById('myModal').style.display = "block";
  document.getElementById('booking_id').value = booking_id;
  document.getElementById('room_type').value = room_type;
  document.getElementById('room_level').value = room_level;
  document.getElementById('booking_date').value = booking_date;
  document.getElementById('check_in_date').value = check_in_date;
  document.getElementById('check_out_date').value = check_out_date;
  document.getElementById('days').value = days;
  document.getElementById('bed_selection').value = bed_selection;
  document.getElementById('smoke').value = smoke;
  document.getElementById('first_name').value = first_name;
  document.getElementById('last_name').value = last_name;
  document.getElementById('email').value = email;
  document.getElementById('phone_number').value = phone_number;
  document.getElementById('car_plates').value = car_plates;

  // Generate room inputs based on number_of_rooms
  generateRoomInputs(number_of_rooms, room_type, room_level);
}

// Function to generate room inputs dynamically
function generateRoomInputs(number_of_rooms, room_type, room_level) {
  const roomList = document.getElementById('room-list');
  roomList.innerHTML = '';

  for (let i = 1; i <= number_of_rooms; i++) {
    const roomItem = document.createElement('div');
    roomItem.className = 'room-item';
    roomItem.innerHTML = `
      <p><strong>Room ${i}</strong></p>
      <p><strong>Room Level:</strong> ${room_level}</p>
      <p><strong>Room Number:</strong> 
        <select name="room_number_${i}">
          ${generateRoomNumberOptions(room_type, room_level)}
        </select>
      </p>
      <p><strong>Extra Bed:</strong> <input type="number" name="extra_bed_${i}" value="0"></p>
      <p><strong>Breakfast:</strong> <input type="number" name="breakfast_${i}" value="0"></p>
    `;
    roomList.appendChild(roomItem);
  }
}

// Function to generate room number options
function generateRoomNumberOptions(room_type, room_level) {
  const roomNumbers = generateRoomNumbers(room_type, room_level);
  return roomNumbers.map(roomNumber => 
    `<option value="${roomNumber}">${roomNumber}</option>`
  ).join('');
}

// Function to close the modal
function closeModal() {
  document.getElementById('myModal').style.display = "none";
}

// Function to generate room numbers dynamically
function generateRoomNumbers(room_type, room_level) {
  var roomNumbers = [];
  var quantity = (room_type === 'Family Suite') ? 5 : 10;
  for (var i = 1; i <= quantity; i++) {
    var roomNumber = room_level * 100 + i;
    roomNumbers.push(roomNumber);
  }
  return roomNumbers;
}

// Close the modal if the user clicks outside of it
window.onclick = function(event) {
  if (event.target == document.getElementById('myModal')) {
    closeModal();
  }
}

// Handle form submission
document.getElementById('modifyForm').addEventListener('submit', function(event) {
  event.preventDefault();
  // Check if all room numbers are selected
  const roomNumbers = document.querySelectorAll('#room-list select');
  let allSelected = true;
  roomNumbers.forEach(select => {
    if (select.value === '') {
      allSelected = false;
    }
  });

  if (allSelected) {
    // Update booking status to 'Success' and save changes
    const formData = new FormData(this);
    fetch('modify_booking.php', {
      method: 'POST',
      body: formData
    }).then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Room update successful!');
          setTimeout(() => {
            closeModal();
            location.reload();
          }, 5000);
        } else {
          alert('Failed to update rooms. Please try again.');
        }
      })
      .catch(error => console.error('Error:', error));
  } else {
    alert('Please assign all room numbers before saving.');
  }
});
</script>
</body>
</html>
