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
      .then(data => document.getElementById('booking-rows').innerHTML = data)
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

  window.openCancelModal = (bookingId) => {
    document.getElementById('cancelBookingId').value = bookingId;
    document.getElementById('cancelModal').style.display = 'block';
  };

  window.closeCancelModal = () => {
    document.getElementById('cancelModal').style.display = 'none';
  };

  window.viewReceipt = (bookingId) => {
    window.location.href = `../invoice.php?booking_id=${bookingId}`;
  };

  window.openBookingModal = (bookingData) => {
    document.getElementById('modal-booking-id').value = bookingData.booking_id;
    document.getElementById('modal-booking-date').value = bookingData.booking_date;
    document.getElementById('modal-room-type').value = bookingData.room_type;
    document.getElementById('modal-check-in-date').value = bookingData.check_in_date;
    document.getElementById('modal-check-out-date').value = bookingData.check_out_date;
    document.getElementById('modal-stay-days').value = bookingData.stay_days;
    document.getElementById('modal-room-quantity').value = bookingData.room_quantity;
    document.getElementById('modal-bed-selection').value = bookingData.bed_selection;
    document.getElementById('modal-smoke').value = bookingData.smoke;
    document.getElementById('modal-total-amount').value = bookingData.total_amount;
    document.getElementById('modal-customer-name').value = bookingData.customer_name;
    document.getElementById('modal-email').value = bookingData.email;
    document.getElementById('modal-phone').value = bookingData.phone;
    document.getElementById('modal-bring-car').value = bookingData.bring_car;
    document.getElementById('modal-car-plate').value = bookingData.car_plate;
    document.getElementById('additional-requests').innerHTML = bookingData.additional_requests;
    document.getElementById('bookingModal').style.display = 'block';
  };

  window.closeBookingModal = () => {
    document.getElementById('bookingModal').style.display = 'none';
  };

  document.getElementById('booking-id').addEventListener('keyup', fetchBookings);
  document.getElementById('user-info').addEventListener('keyup', fetchBookings);
  document.getElementById('check-in-date').addEventListener('change', fetchBookings);
  document.getElementById('booking-status').addEventListener('change', fetchBookings);
  document.getElementById('room-type').addEventListener('change', fetchBookings);

  document.getElementById('clear-filters-button').addEventListener('click', clearFilters);

  fetchBookings();
});
