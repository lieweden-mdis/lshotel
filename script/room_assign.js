document.addEventListener("DOMContentLoaded", function() {
  // Function to open the Assign Room Modal
  function openAssignRoomModal(bookingId, bookingDate, checkInDate, checkOutDate, customerName, customerEmail, roomType, roomQuantity, roomLevel) {
    document.getElementById('modalBookingIdText').value = bookingId;
    document.getElementById('modalBookingDate').value = bookingDate;
    document.getElementById('modalCheckInDate').value = checkInDate;
    document.getElementById('modalCheckOutDate').value = checkOutDate;
    document.getElementById('modalCustomerName').value = customerName;
    document.getElementById('modalCustomerEmail').value = customerEmail;
    document.getElementById('modalRoomType').value = roomType;
    document.getElementById('modalRoomLevel').value = roomLevel;

    const roomsContainer = document.getElementById('roomsContainer');
    roomsContainer.innerHTML = ''; // Clear previous fields

    for (let i = 0; i < roomQuantity; i++) {
      const roomAssignment = document.createElement('div');
      roomAssignment.className = 'assign-room-room-assignment';

      let optionsHtml = '<option value="">Select Room Number</option>';
      availableRooms.forEach(room => {
        if (room.room_type === roomType && room.room_level == roomLevel) {
          optionsHtml += `<option value="${room.room_number}">${room.room_number}</option>`;
        }
      });

      roomAssignment.innerHTML = `
        <label>Room ${i + 1} - Room Number</label>
        <select name="room_number_${i}" required>
          ${optionsHtml}
        </select>
      `;

      roomsContainer.appendChild(roomAssignment);
    }

    document.getElementById('assignRoomModal').style.display = 'block';
  }

  function closeAssignRoomModal() {
    document.getElementById('assignRoomModal').style.display = 'none';
  }

  function assignRooms() {
    const bookingId = document.getElementById('modalBookingIdText').value;
    const roomAssignments = [];

    const roomsContainer = document.getElementById('roomsContainer');
    const roomFields = roomsContainer.querySelectorAll('select');

    let allRoomsSelected = true;
    roomFields.forEach((field, index) => {
      const roomNumber = field.value;
      if (roomNumber === "") {
        allRoomsSelected = false;
      }
      roomAssignments.push({ roomNumber });
    });

    if (!allRoomsSelected) {
      showCustomAlert('Please select a room number for each room.');
      return;
    }

    const requestData = {
      booking_id: bookingId,
      room_assignments: roomAssignments
    };

    fetch('assign_room_action.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(requestData)
    }).then(response => response.json())
      .then(data => {
        if (data.success) {
          showSuccessMessage('Rooms assigned successfully.');
          closeAssignRoomModal();
          setTimeout(() => {
            location.reload(); // Reload page to see updates
          }, 3000);
        } else {
          showCustomAlert('Failed to assign rooms.');
        }
      }).catch(error => {
        console.error('Error:', error);
        showCustomAlert('An error occurred.');
      });
  }

  function showSuccessMessage(message) {
    const successMessageElement = document.getElementById('successMessage');
    successMessageElement.innerText = message;
    successMessageElement.style.display = 'block';
    setTimeout(() => {
      successMessageElement.style.display = 'none';
    }, 3000);
  }

  function showCustomAlert(message) {
    document.getElementById('customAlertMessage').innerText = message;
    document.getElementById('customAlertModal').style.display = 'block';
  }

  function closeCustomAlertModal() {
    document.getElementById('customAlertModal').style.display = 'none';
  }

  // Expose functions to the global scope
  window.openAssignRoomModal = openAssignRoomModal;
  window.closeAssignRoomModal = closeAssignRoomModal;
  window.assignRooms = assignRooms;
  window.closeCustomAlertModal = closeCustomAlertModal;
});
