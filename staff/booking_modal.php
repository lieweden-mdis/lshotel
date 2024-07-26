<div id="bookingModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeBookingModal()">&times;</span>
    <div class="modal-section">
      <h3>Booking Information</h3>
      <div class="modal-grid">
        <div class="grid-item">
          <label for="modal-booking-id">Booking ID</label>
          <input type="text" id="modal-booking-id" readonly>
        </div>
        <div class="grid-item">
          <label for="modal-booking-date">Booking Date</label>
          <input type="text" id="modal-booking-date" readonly>
        </div>
        <div class="grid-item">
          <label for="modal-room-type">Room Type</label>
          <input type="text" id="modal-room-type" readonly>
        </div>
        <div class="grid-item">
          <label for="modal-check-in-date">Check-in Date</label>
          <input type="text" id="modal-check-in-date" readonly>
        </div>
        <div class="grid-item">
          <label for="modal-check-out-date">Check-out Date</label>
          <input type="text" id="modal-check-out-date" readonly>
        </div>
        <div class="grid-item">
          <label for="modal-stay-days">Stay Days</label>
          <input type="text" id="modal-stay-days" readonly>
        </div>
        <div class="grid-item">
          <label for="modal-room-quantity">Room Quantity</label>
          <input type="text" id="modal-room-quantity" readonly>
        </div>
        <div class="grid-item">
          <label for="modal-bed-selection">Bed Selection</label>
          <input type="text" id="modal-bed-selection">
        </div>
        <div class="grid-item">
          <label for="modal-smoke">Smoke</label>
          <input type="text" id="modal-smoke">
        </div>
        <div class="grid-item">
          <label for="modal-total-amount">Total Amount</label>
          <input type="text" id="modal-total-amount" readonly>
        </div>
      </div>
    </div>
    <div class="modal-section">
      <h3>Guest Information</h3>
      <div class="modal-grid">
        <div class="grid-item">
          <label for="modal-customer-name">Customer Name</label>
          <input type="text" id="modal-customer-name">
        </div>
        <div class="grid-item">
          <label for="modal-email">Email</label>
          <input type="text" id="modal-email">
        </div>
        <div class="grid-item">
          <label for="modal-phone">Phone</label>
          <input type="text" id="modal-phone">
        </div>
        <div class="grid-item">
          <label for="modal-bring-car">Bring Car</label>
          <input type="text" id="modal-bring-car">
        </div>
        <div class="grid-item">
          <label for="modal-car-plate">Car Plate</label>
          <input type="text" id="modal-car-plate">
        </div>
      </div>
    </div>
    <div class="modal-actions">
      <button type="button" onclick="closeBookingModal()">Close</button>
      <button type="button" onclick="saveBookingChanges()">Save Changes</button>
    </div>
  </div>
</div>
