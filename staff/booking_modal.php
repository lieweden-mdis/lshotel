<div id="bookingModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2>Booking Detail</h2>
      <span class="success-message" id="successMessage">Booking updated successfully!</span>
      <span class="error-message" id="errorMessage"></span>
      <span class="close" onclick="closeModal()">&times;</span>
    </div>
    <div class="modal-section">
      <h3>Booking Information</h3>
      <hr>
      <div class="modal-grid">
        <div class="modal-grid-item">
          <div class="label-container">
            <label for="booking-id">Booking ID:</label>
          </div>
          <input type="text" id="booking-id" class="no-edit" readonly>
        </div>
        <div class="modal-grid-item">
          <div class="label-container">
            <label for="booking-date">Booking Date:</label>
          </div>
          <input type="text" id="booking-date" class="no-edit" readonly>
        </div>
        <div class="modal-grid-item">
          <div class="label-container">
            <label for="room-type">Room Type:</label>
          </div>
          <input type="text" id="room-type" class="no-edit" readonly>
        </div>
        <div class="modal-grid-item">
          <div class="label-container">
            <label for="check-in-date">Check In Date:</label>
            <button type="button" class="edit-btn" onclick="enableEdit('check-in-date')">Edit</button>
          </div>
          <input type="date" id="check-in-date" readonly>
        </div>
        <div class="modal-grid-item">
          <div class="label-container">
            <label for="check-out-date">Check Out Date:</label>
            <button type="button" class="edit-btn" onclick="enableEdit('check-out-date')">Edit</button>
          </div>
          <input type="date" id="check-out-date" readonly>
        </div>
        <div class="modal-grid-item">
          <div class="label-container">
            <label for="stay-days">Days of Stay:</label>
          </div>
          <input type="text" id="stay-days" class="no-edit" readonly>
        </div>
        <div class="modal-grid-item">
          <div class="label-container">
            <label for="room-quantity">Room Quantity:</label>
          </div>
          <input type="text" id="room-quantity" class="no-edit" readonly>
        </div>
        <div class="modal-grid-item">
          <div class="label-container">
            <label for="bed-selection">Bed Selection:</label>
            <button type="button" class="edit-btn" onclick="enableDropdown('bed-selection')">Edit</button>
          </div>
          <select id="bed-selection" class="dropdown" disabled>
            <option value="" selected disabled hidden></option>
          </select>
        </div>
        <div class="modal-grid-item">
          <div class="label-container">
            <label for="smoke">Smoke:</label>
            <button type="button" class="edit-btn" onclick="enableDropdown('smoke')">Edit</button>
          </div>
          <select id="smoke" class="dropdown" disabled>
            <option value="" selected disabled hidden></option>
          </select>
        </div>
        <div class="modal-grid-item">
          <div class="label-container">
            <label for="total-amount">Total Amount Paid:</label>
          </div>
          <input type="text" id="total-amount" class="no-edit" value="RM " readonly>
        </div>
      </div>
    </div>
    <div class="modal-section">
      <h3>Additional Requests</h3>
      <hr>
      <div id="additional-charges" class="modal-grid-2">
        <!-- Dynamic content will be inserted here by JavaScript -->
      </div>
    </div>
    <div class="modal-section">
      <h3>Guest Information</h3>
      <hr>
      <div class="modal-grid">
        <div class="modal-grid-item">
          <div class="label-container">
            <label for="customer-name">Customer Name:</label>
            <button type="button" class="edit-btn" onclick="enableEdit('customer-name')">Edit</button>
          </div>
          <input type="text" id="customer-name" readonly>
        </div>
        <div class="modal-grid-item">
          <div class="label-container">
            <label for="email">Email:</label>
            <button type="button" class="edit-btn" onclick="enableEdit('email')">Edit</button>
          </div>
          <input type="text" id="email" readonly>
        </div>
        <div class="modal-grid-item">
          <div class="label-container">
            <label for="phone">Phone Number:</label>
            <button type="button" class="edit-btn" onclick="enableEdit('phone')">Edit</button>
          </div>
          <input type="text" id="phone" readonly>
        </div>
        <div class="modal-grid-item">
          <div class="label-container">
            <label for="bring-car">Bring Car:</label>
            <button type="button" class="edit-btn" onclick="enableDropdown('bring-car')">Edit</button>
          </div>
          <select id="bring-car" class="dropdown" disabled>
            <option value="" selected disabled hidden></option>
          </select>
        </div>
        <div class="modal-grid-item">
          <div class="label-container">
            <label for="car-plate">Car Plate Number:</label>
            <button type="button" class="edit-btn" onclick="enableEdit('car-plate')">Edit</button>
          </div>
          <input type="text" id="car-plate" readonly>
        </div>
      </div>
    </div>
    <div class="modal-actions">
      <button class="exit-btn" onclick="closeModal()">Exit</button>
      <button class="save-btn" onclick="confirmUpdate()">Save</button>
    </div>
  </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeConfirmModal()">&times;</span>
    <p>Are you sure you want to save the changes?</p>
    <div class="modal-actions">
      <button class="confirm-btn" onclick="updateBooking()">Yes</button>
      <button class="cancel-btn" onclick="closeConfirmModal()">No</button>
    </div>
  </div>
</div>
