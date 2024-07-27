<div id="cancelModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeCancelModal()">&times;</span>
    <form id="cancelForm">
      <input type="hidden" id="cancelBookingId" name="booking_id">
      <label for="cancel_reason">Reason for Cancellation:</label>
      <textarea id="cancel_reason" name="cancel_reason" rows="4" cols="50" required></textarea>
      <input type="hidden" id="number_of_rooms" name="number_of_rooms">
      <button type="submit">Cancel Booking</button>
      <button type="button" onclick="closeCancelModal()">Close</button>
    </form>
  </div>
</div>
