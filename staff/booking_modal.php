<div id="bookingModal" class="booking-modal">
  <div class="booking-modal-content">
    <span class="booking-close" onclick="closeBookingModal()">&times;</span>
    <h2>Booking Details</h2>
    <div class="booking-modal-section">
      <div class="booking-modal-grid">
        <div class="booking-grid-item">
          <label for="modal-booking-id">Booking ID</label>
          <div style="display: flex;">
            <input type="text" id="modal-booking-id" readonly>
            <span class="edit-placeholder"></span>
          </div>
        </div>
        <div class="booking-grid-item">
          <label for="modal-booking-date">Booking Date</label>
          <div style="display: flex;">
            <input type="text" id="modal-booking-date" readonly>
            <span class="edit-placeholder"></span>
          </div>
        </div>
        <div class="booking-grid-item">
          <label for="modal-room-type">Room Type</label>
          <div style="display: flex;">
            <input type="text" id="modal-room-type" readonly>
            <span class="edit-placeholder"></span>
          </div>
        </div>
        <div class="booking-grid-item">
          <label for="modal-check-in-date">Check-in Date</label>
          <div style="display: flex;">
            <input type="date" id="modal-check-in-date" readonly>
            <span class="edit-placeholder"></span>
          </div>
        </div>
        <div class="booking-grid-item">
          <label for="modal-check-out-date">Check-out Date</label>
          <div style="display: flex;">
            <input type="date" id="modal-check-out-date" readonly>
            <span class="edit-placeholder"></span>
          </div>
        </div>
        <div class="booking-grid-item">
          <label for="modal-stay-days">Stay Days</label>
          <div style="display: flex;">
            <input type="text" id="modal-stay-days" readonly>
            <span class="edit-placeholder"></span>
          </div>
        </div>
        <div class="booking-grid-item">
          <label for="modal-room-quantity">Room Quantity</label>
          <div style="display: flex;">
            <input type="text" id="modal-room-quantity" readonly>
            <span class="edit-placeholder"></span>
          </div>
        </div>
        <div class="booking-grid-item">
          <label for="modal-bed-selection">Bed Selection</label>
          <div style="display: flex;">
            <select id="modal-bed-selection" disabled></select>
            <button type="button" class="booking-edit-button" onclick="editField('modal-bed-selection')">Edit</button>
          </div>
        </div>
        <div class="booking-grid-item">
          <label for="modal-smoke">Smoke Preference</label>
          <div style="display: flex;">
            <select id="modal-smoke" disabled></select>
            <button type="button" class="booking-edit-button" onclick="editField('modal-smoke')">Edit</button>
          </div>
        </div>
        <div class="booking-grid-item">
          <label for="modal-total-amount">Total Amount</label>
          <div style="display: flex;">
            <input type="text" id="modal-total-amount" readonly>
            <span class="edit-placeholder"></span>
          </div>
        </div>
      </div>
    </div>
    <h2>Customer Details</h2>
    <div class="booking-modal-section">
      <div class="booking-modal-grid">
        <div class="booking-grid-item">
          <label for="modal-first-name">First Name</label>
          <div style="display: flex;">
            <input type="text" id="modal-first-name" readonly>
            <button type="button" class="booking-edit-button" onclick="editField('modal-first-name')">Edit</button>
          </div>
        </div>
        <div class="booking-grid-item">
          <label for="modal-last-name">Last Name</label>
          <div style="display: flex;">
            <input type="text" id="modal-last-name" readonly>
            <button type="button" class="booking-edit-button" onclick="editField('modal-last-name')">Edit</button>
          </div>
        </div>
        <div class="booking-grid-item">
          <label for="modal-email">Email</label>
          <div style="display: flex;">
            <input type="email" id="modal-email" readonly>
            <button type="button" class="booking-edit-button" onclick="editField('modal-email')">Edit</button>
          </div>
        </div>
        <div class="booking-grid-item">
          <label for="modal-phone">Phone</label>
          <div style="display: flex;">
            <input type="tel" id="modal-phone" readonly>
            <button type="button" class="booking-edit-button" onclick="editField('modal-phone')">Edit</button>
          </div>
        </div>
        <div class="booking-grid-item">
          <label for="modal-bring-car">Bringing Car</label>
          <div style="display: flex;">
            <select id="modal-bring-car" disabled>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
            <button type="button" class="booking-edit-button" onclick="editField('modal-bring-car')">Edit</button>
          </div>
        </div>
        <div class="booking-grid-item">
          <label for="modal-car-plate">Car Plate</label>
          <div style="display: flex;">
            <input type="text" id="modal-car-plate" readonly>
            <button type="button" class="booking-edit-button" onclick="editField('modal-car-plate')">Edit</button>
          </div>
        </div>
      </div>
    </div>
    <div class="booking-modal-actions">
      <button type="button" class="booking-close-button" onclick="closeBookingModal()">Close</button>
      <button type="button" class="booking-update-button" onclick="updateBooking()">Update</button>
    </div>
  </div>
</div>
