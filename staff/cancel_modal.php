<div id="cancelModal" class="cancel-modal">
  <div class="cancel-modal-content">
    <span class="cancel-close" onclick="closeCancelModal()">&times;</span>
    <h2>Cancel Booking</h2>
    <form id="cancelForm">
      <input type="hidden" id="cancel-booking-id" name="cancel-booking-id">
      <label for="cancel_reason">Reason for Cancellation:</label>
      <textarea id="cancel_reason" name="cancel_reason" required></textarea>
      <div class="cancel-modal-actions">
        <button type="button" class="cancel-button cancel-no-button" onclick="closeCancelModal()">No</button>
        <button type="submit" class="cancel-button cancel-yes-button">Yes, Cancel</button>
      </div>
    </form>
  </div>
</div>
