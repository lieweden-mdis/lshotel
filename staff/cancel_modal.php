<div id="cancelModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeCancelModal()">&times;</span>
        <form id="cancelForm">
            <h2>Cancel Booking</h2>
            <input type="hidden" id="cancelBookingId" name="cancelBookingId">
            <input type="hidden" id="numberOfRooms" name="numberOfRooms">
            <label for="cancelReason">Reason for Cancellation:</label>
            <textarea id="cancelReason" name="cancelReason" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
</div>
