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
    console.log('Opening assign room modal for booking ID:', bookingId);
    document.getElementById('modalBookingIdText').value = bookingId;
    document.getElementById('modalBookingDate').value = bookingDate;
    document.getElementById('modalCheckInDate').value = checkInDate;
    document.getElementById('modalCheckOutDate').value = checkOutDate;
    document.getElementById('modalCustomerName').value = name;
    document.getElementById('modalCustomerEmail').value = email;
    document.getElementById('modalRoomType').value = roomType;
    document.getElementById('modalRoomLevel').value = roomLevel;

    roomsContainer.innerHTML = '';

    for (let i = 0; i < numberOfRooms; i++) {
      const roomSelect = document.createElement('select');
      roomSelect.name = 'roomSelect' + i;
      roomSelect.className = 'room-select';

      availableRooms.forEach(room => {
        const option = document.createElement('option');
        option.value = room.room_id;
        option.text = room.room_number;
        roomSelect.appendChild(option);
      });

      roomsContainer.appendChild(roomSelect);
    }

    assignRoomModal.style.display = 'block';
  }

  // Function to close the assign room modal
  function closeAssignRoomModal() {
    console.log('Closing assign room modal');
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

  // Attach functions to window object to make them accessible
  window.openAssignRoomModal = openAssignRoomModal;
  window.closeAssignRoomModal = closeAssignRoomModal;
  window.filterTable = filterTable;
  window.clearFilters = clearFilters;

  // Attach filter event listeners if filter inputs are present
  const bookingIdInput = document.getElementById('booking_id');
  const customerNameInput = document.getElementById('customer_name');
  const customerEmailInput = document.getElementById('customer_email');

  if (bookingIdInput) bookingIdInput.addEventListener('input', filterTable);
  if (customerNameInput) customerNameInput.addEventListener('input', filterTable);
  if (customerEmailInput) customerEmailInput.addEventListener('input', filterTable);

  // Handle assign rooms if a form for that exists
  const assignRoomButton = document.querySelector('.assign-room-button');
  if (assignRoomButton) {
    assignRoomButton.addEventListener('click', function() {
      console.log('Assigning rooms');
      // Your room assignment logic here
    });
  }
});
