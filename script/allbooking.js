document.addEventListener('DOMContentLoaded', () => {
  window.fetchBookings = () => {
    const params = new URLSearchParams({
      booking_id: document.getElementById('booking-id').value,
      user_info: document.getElementById('user-info').value,
      check_in_date: document.getElementById('check-in-date').value,
      status: document.getElementById('booking-status').value,
      room_type: document.getElementById('room-type').value,
    });

    fetch(`fetch_bookings.php?${params.toString()}`)
      .then(response => response.text())
      .then(data => {
        console.log('Fetch bookings response:', data); // Log the response
        document.getElementById('booking-rows').innerHTML = data;
      })
      .catch(error => console.error('Error fetching bookings:', error));
  };

  window.clearFilters = () => {
    document.getElementById('booking-id').value = '';
    document.getElementById('user-info').value = '';
    document.getElementById('check-in-date').value = '';
    document.getElementById('booking-status').value = '';
    document.getElementById('room-type').value = '';
    fetchBookings();
  };

  window.fetchBookingDetails = (bookingId) => {
    fetch(`fetch_bookings.php?booking_id=${bookingId}`)
      .then(response => response.json())
      .then(booking => {
        console.log('Fetch booking details response:', booking); // Log the response
        if (!booking || !booking.booking_id) {
          console.error('Booking not found or invalid response');
          return;
        }

        document.getElementById('modal-booking-id').value = booking.booking_id;
        document.getElementById('modal-booking-date').value = booking.booking_date;
        document.getElementById('modal-room-type').value = booking.room_type;
        document.getElementById('modal-check-in-date').value = booking.check_in_date;
        document.getElementById('modal-check-out-date').value = booking.check_out_date;
        document.getElementById('modal-stay-days').value = booking.stay_days;
        document.getElementById('modal-room-quantity').value = booking.room_quantity;
        
        const bedSelection = document.getElementById('modal-bed-selection');
        bedSelection.innerHTML = booking.bed_selection_options.map(option => `<option value="${option}">${option}</option>`).join('');
        bedSelection.value = booking.bed_selection;

        const smokePreference = document.getElementById('modal-smoke');
        smokePreference.innerHTML = booking.smoke_options.map(option => `<option value="${option}">${option}</option>`).join('');
        smokePreference.value = booking.smoke;

        document.getElementById('modal-total-amount').value = booking.total_amount;
        document.getElementById('modal-first-name').value = booking.first_name;
        document.getElementById('modal-last-name').value = booking.last_name;
        document.getElementById('modal-email').value = booking.email;
        document.getElementById('modal-phone').value = booking.phone;
        document.getElementById('modal-bring-car').value = booking.bring_car;
        document.getElementById('modal-car-plate').value = booking.car_plate;
        document.getElementById('bookingModal').style.display = 'block';
      })
      .catch(error => console.error('Error fetching booking details:', error));
  };

  window.closeBookingModal = () => {
    document.getElementById('bookingModal').style.display = 'none';
  };

  window.editField = (fieldId) => {
    const field = document.getElementById(fieldId);
    field.classList.add('editable');
    if (field.tagName === 'SELECT') {
      field.disabled = false;
      if (fieldId === 'modal-bring-car') {
        field.addEventListener('change', () => {
          if (field.value === 'No') {
            document.getElementById('modal-car-plate').value = '';
          }
        });
      }
    } else {
      field.readOnly = false;
      field.style.cursor = "text";
    }
  };

  window.updateBooking = () => {
    const bookingData = {
      booking_id: document.getElementById('modal-booking-id').value,
      first_name: document.getElementById('modal-first-name').value,
      last_name: document.getElementById('modal-last-name').value,
      email: document.getElementById('modal-email').value,
      phone: document.getElementById('modal-phone').value,
      bring_car: document.getElementById('modal-bring-car').value,
      car_plate: document.getElementById('modal-car-plate').value,
      bed_selection: document.getElementById('modal-bed-selection').value,
      smoke: document.getElementById('modal-smoke').value
    };

    fetch('update_booking.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(bookingData)
    })
    .then(response => response.text())
    .then(result => {
      const messageElement = document.getElementById('message');
      if (messageElement) {
        if (result.trim() === 'Success') {
          messageElement.innerText = 'Booking updated successfully';
          messageElement.style.display = 'block';
          setTimeout(() => {
            messageElement.style.display = 'none';
          }, 3000);
          fetchBookings();
          closeBookingModal();
        } else {
          console.error('Error:', result);
        }
      } else {
        console.error('Error: Message element not found.');
      }
    })
    .catch(error => console.error('Error:', error));
  };

  document.getElementById('cancelForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('cancel_booking.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(result => {
      const messageElement = document.getElementById('message');
      if (messageElement) {
        if (result.trim() === 'Success') {
          closeCancelModal();
          messageElement.innerText = 'Booking cancelled successfully';
          messageElement.style.display = 'block';
          setTimeout(() => {
            messageElement.style.display = 'none';
          }, 3000);
          fetchBookings();
        } else {
          console.error('Error:', result);
        }
      } else {
        console.error('Error: Message element not found.');
      }
    })
    .catch(error => console.error('Error:', error));
  });

  document.getElementById('booking-id').addEventListener('keyup', fetchBookings);
  document.getElementById('user-info').addEventListener('keyup', fetchBookings);
  document.getElementById('check-in-date').addEventListener('change', fetchBookings);
  document.getElementById('booking-status').addEventListener('change', fetchBookings);
  document.getElementById('room-type').addEventListener('change', fetchBookings);

  document.getElementById('clear-filters-button').addEventListener('click', clearFilters);

  fetchBookings();
});
