document.addEventListener('DOMContentLoaded', () => {
  window.openBookingModal = (bookingData) => {
    const setModalValue = (id, value) => {
      const element = document.getElementById(id);
      if (element) {
        element.value = value;
      }
    };

    setModalValue('modal-booking-id', bookingData.booking_id);
    setModalValue('modal-booking-date', bookingData.booking_date);
    setModalValue('modal-room-type', bookingData.room_type);
    setModalValue('modal-check-in-date', bookingData.check_in_date);
    setModalValue('modal-check-out-date', bookingData.check_out_date);
    setModalValue('modal-stay-days', bookingData.stay_days);
    setModalValue('modal-room-quantity', bookingData.room_quantity);
    setModalValue('modal-bed-selection', bookingData.bed_selection);
    setModalValue('modal-smoke', bookingData.smoke);
    setModalValue('modal-total-amount', bookingData.total_amount);
    setModalValue('modal-customer-name', bookingData.customer_name);
    setModalValue('modal-email', bookingData.email);
    setModalValue('modal-phone', bookingData.phone);
    setModalValue('modal-bring-car', bookingData.bring_car);
    setModalValue('modal-car-plate', bookingData.car_plate);

    document.getElementById('bookingModal').style.display = 'block';
  };

  window.closeBookingModal = () => {
    document.getElementById('bookingModal').style.display = 'none';
  };

  window.saveBookingChanges = () => {
    const bookingId = document.getElementById('modal-booking-id').value;
    const updatedData = {
      bed_selection: document.getElementById('modal-bed-selection').value,
      smoke: document.getElementById('modal-smoke').value,
      customer_name: document.getElementById('modal-customer-name').value,
      email: document.getElementById('modal-email').value,
      phone: document.getElementById('modal-phone').value,
      bring_car: document.getElementById('modal-bring-car').value,
      car_plate: document.getElementById('modal-car-plate').value,
    };

    fetch(`update_booking.php?booking_id=${bookingId}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(updatedData),
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Booking updated successfully');
          closeBookingModal();
          // Optionally refresh the booking data here
        } else {
          alert('Error updating booking');
        }
      })
      .catch(error => console.error('Error updating booking:', error));
  };
});
