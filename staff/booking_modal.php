<div id="bookingModal" class="booking-modal">
  <div class="booking-modal-content">
    <span class="booking-close" onclick="closeBookingModal()">&times;</span>
    <h2>Booking Details</h2>
    <div class="booking-modal-section">
      <div class="booking-modal-grid">
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-booking-id">Booking ID</label>
          </div>
          <input type="text" id="modal-booking-id" readonly>
        </div>
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-booking-date">Booking Date</label>
          </div>
          <input type="text" id="modal-booking-date" readonly>
        </div>
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-room-type">Room Type</label>
          </div>
          <input type="text" id="modal-room-type" readonly>
        </div>
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-check-in-date">Check-in Date</label>
          </div>
          <input type="date" id="modal-check-in-date" readonly>
        </div>
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-check-out-date">Check-out Date</label>
          </div>
          <input type="date" id="modal-check-out-date" readonly>
        </div>
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-stay-days">Stay Days</label>
          </div>
          <input type="text" id="modal-stay-days" readonly>
        </div>
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-room-quantity">Room Quantity</label>
          </div>
          <input type="text" id="modal-room-quantity" readonly>
        </div>
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-bed-selection">Bed Selection</label>
            <button type="button" class="booking-edit-button" onclick="editField('modal-bed-selection')">Edit</button>
          </div>
          <select id="modal-bed-selection" disabled></select>
        </div>
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-smoke">Smoke Preference</label>
            <button type="button" class="booking-edit-button" onclick="editField('modal-smoke')">Edit</button>
          </div>
          <select id="modal-smoke" disabled></select>
        </div>
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-total-amount">Total Amount</label>
          </div>
          <input type="text" id="modal-total-amount" readonly>
        </div>
      </div>
    </div>
    <h2>Customer Details</h2>
    <div class="booking-modal-section">
      <div class="booking-modal-grid">
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-first-name">First Name</label>
            <button type="button" class="booking-edit-button" onclick="editField('modal-first-name')">Edit</button>
          </div>
          <input type="text" id="modal-first-name" readonly>
        </div>
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-last-name">Last Name</label>
            <button type="button" class="booking-edit-button" onclick="editField('modal-last-name')">Edit</button>
          </div>
          <input type="text" id="modal-last-name" readonly>
        </div>
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-email">Email</label>
            <button type="button" class="booking-edit-button" onclick="editField('modal-email')">Edit</button>
          </div>
          <input type="email" id="modal-email" readonly>
        </div>
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-phone">Phone</label>
            <button type="button" class="booking-edit-button" onclick="editField('modal-phone')">Edit</button>
          </div>
          <input type="tel" id="modal-phone" readonly>
        </div>
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-bring-car">Bringing Car</label>
            <button type="button" class="booking-edit-button" onclick="editField('modal-bring-car')">Edit</button>
          </div>
          <select id="modal-bring-car" readonly>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </div>
        <div class="booking-grid-item">
          <div class="label-edit">
            <label for="modal-car-plate">Car Plate</label>
            <button type="button" class="booking-edit-button" onclick="editField('modal-car-plate')">Edit</button>
          </div>
          <input type="text" id="modal-car-plate" readonly>
        </div>
      </div>
    </div>
    <div class="booking-modal-actions">
      <button type="button" class="booking-close-button" onclick="closeBookingModal()">Close</button>
      <button type="button" class="booking-update-button" onclick="updateBooking()">Update</button>
    </div>
  </div>
</div>
