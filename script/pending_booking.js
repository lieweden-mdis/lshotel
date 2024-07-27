document.addEventListener('DOMContentLoaded', function() {
    // Ensure all required elements are present
    const assignRoomModal = document.getElementById('assignRoomModal');
    const successMessage = document.getElementById('successMessage');
    const bookingTable = document.getElementById('bookingTable');
    const roomsContainer = document.getElementById('roomsContainer');
  
    if (!assignRoomModal || !successMessage || !bookingTable || !roomsContainer) {
      console.error('One or more required elements are missing from the DOM.');
      return;
    }
  
    // Function to open the assign room modal
    function openAssignRoomModal(bookingId, bookingDate, checkInDate, checkOutDate, name, email, roomType, numberOfRooms, roomLevel) {
      document.getElementById('modalBookingIdText').value = bookingId;
      document.getElementById('modalBookingDate').value = bookingDate;
      document.getElementById('modalCheckInDate').value = checkInDate;
      document.getElementById('modalCheckOutDate').value = checkOutDate;
      document.getElementById('modalCustomerName').value = name;
      document.getElementById('modalCustomerEmail').value = email;
      document.getElementById('modalRoomType').value = roomType;
      document.getElementById('modalRoomLevel').value = roomLevel;
  
      roomsContainer.innerHTML = ''; // Clear previous fields
  
      for (let i = 0; i < numberOfRooms; i++) {
        const roomAssignment = document.createElement('div');
        roomAssignment.className = 'assign-room-room-assignment';
  
        let optionsHtml = '<option value="">Select Room Number</option>';
        availableRooms.forEach(room => {
          if (room.room_level == roomLevel && room.assign_status === 'Not Assign') {
            optionsHtml += `<option value="${room.room_number}">${room.room_number}</option>`;
          }
        });
  
        roomAssignment.innerHTML = `
          <label>Room ${i + 1} - Room Number</label>
          <select name="room_assignments[]">
            ${optionsHtml}
          </select>
        `;
  
        roomsContainer.appendChild(roomAssignment);
      }
  
      assignRoomModal.style.display = 'block';
    }
  
    // Function to close the assign room modal
    function closeAssignRoomModal() {
      assignRoomModal.style.display = 'none';
    }
  
    // Function to filter table rows based on input
    function filterTable() {
      const bookingIdInput = document.getElementById('booking_id').value.toLowerCase();
      const customerNameInput = document.getElementById('customer_name').value.toLowerCase();
      const customerEmailInput = document.getElementById('customer_email').value.toLowerCase();
  
      const tr = bookingTable.getElementsByTagName('tr');
  
      for (let i = 1; i < tr.length; i++) {
        const tdBookingId = tr[i].getElementsByTagName('td')[0];
        const tdCustomerName = tr[i].getElementsByTagName('td')[2];
        const tdCustomerEmail = tr[i].getElementsByTagName('td')[3];
  
        if (tdBookingId && tdCustomerName && tdCustomerEmail) {
          const bookingIdText = tdBookingId.textContent || tdBookingId.innerText;
          const customerNameText = tdCustomerName.textContent || tdCustomerName.innerText;
          const customerEmailText = tdCustomerEmail.textContent || tdCustomerEmail.innerText;
  
          if (bookingIdText.toLowerCase().indexOf(bookingIdInput) > -1 &&
              customerNameText.toLowerCase().indexOf(customerNameInput) > -1 &&
              customerEmailText.toLowerCase().indexOf(customerEmailInput) > -1) {
            tr[i].style.display = '';
          } else {
            tr[i].style.display = 'none';
          }
        }
      }
    }
  
    // Function to clear filters
    function clearFilters() {
      document.getElementById('booking_id').value = '';
      document.getElementById('customer_name').value = '';
      document.getElementById('customer_email').value = '';
      filterTable();
    }
  
    window.openAssignRoomModal = openAssignRoomModal;
    window.closeAssignRoomModal = closeAssignRoomModal;
    window.filterTable = filterTable;
    window.clearFilters = clearFilters;
  
    const bookingIdInput = document.getElementById('booking_id');
    const customerNameInput = document.getElementById('customer_name');
    const customerEmailInput = document.getElementById('customer_email');
  
    if (bookingIdInput) bookingIdInput.addEventListener('input', filterTable);
    if (customerNameInput) customerNameInput.addEventListener('input', filterTable);
    if (customerEmailInput) customerEmailInput.addEventListener('input', filterTable);
  });
  