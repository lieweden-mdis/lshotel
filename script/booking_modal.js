const roomDetails = {
  bed_options: ["Single", "Double", "Queen", "King"],
  smoking_options: ["Smoking", "Non-Smoking"]
};

// Function to enable dropdown for editing
function enableDropdown(dropdownId) {
  const dropdown = document.getElementById(dropdownId);
  dropdown.disabled = false;
  dropdown.focus();
}

// Function to populate dropdowns
function populateDropdowns() {
  // Populate bed selection dropdown
  const bedSelect = document.getElementById('bed-selection');
  bedSelect.innerHTML = '<option value="" selected disabled hidden></option>';
  roomDetails.bed_options.forEach(bed => {
    const option = document.createElement('option');
    option.value = bed;
    option.textContent = bed;
    bedSelect.appendChild(option);
  });

  // Populate smoke selection dropdown
  const smokeSelect = document.getElementById('smoke');
  smokeSelect.innerHTML = '<option value="" selected disabled hidden></option>';
  roomDetails.smoking_options.forEach(smoke => {
    const option = document.createElement('option');
    option.value = smoke;
    option.textContent = smoke;
    smokeSelect.appendChild(option);
  });
}

// Function to open the booking modal
function openBookingModal(booking_id, booking_date, check_in_date, check_out_date, days, number_of_rooms, bed_selection, smoke, total_amount, additional_requests, first_name, last_name, email, phone_number, bring_car, car_plates, room_type) {
  document.getElementById('booking-id').value = booking_id;
  document.getElementById('booking-date').value = booking_date;
  document.getElementById('check-in-date').value = check_in_date;
  document.getElementById('check-out-date').value = check_out_date;
  document.getElementById('stay-days').value = days;
  document.getElementById('room-quantity').value = number_of_rooms;
  document.getElementById('bed-selection').value = bed_selection;
  document.getElementById('smoke').value = smoke;
  document.getElementById('total-amount').value = `RM ${total_amount}`;
  document.getElementById('customer-name').value = `${first_name} ${last_name}`;
  document.getElementById('email').value = email;
  document.getElementById('phone').value = phone_number;
  document.getElementById('bring-car').value = bring_car;
  document.getElementById('car-plate').value = car_plates;
  document.getElementById('bookingModal').style.display = 'block';

  populateDropdowns();
}

// Function to close the booking modal
function closeModal() {
  document.getElementById('bookingModal').style.display = 'none';
}

// Function to show the confirmation modal
function confirmUpdate() {
  document.getElementById('confirmModal').style.display = 'block';
}

// Function to close the confirmation modal
function closeConfirmModal() {
  document.getElementById('confirmModal').style.display = 'none';
}

// Function to update the booking
function updateBooking() {
  // Perform the update booking logic here
  // After updating, display success message and close the modal
  document.getElementById('successMessage').style.display = 'block';
  closeConfirmModal();
  closeModal();
}
