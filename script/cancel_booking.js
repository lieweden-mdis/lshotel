// cancel_booking.js
function openCancelModal(bookingId, numberOfRooms) {
    console.log('Opening cancel modal for booking ID:', bookingId, 'with number of rooms:', numberOfRooms);
    document.getElementById('cancelBookingId').value = bookingId;
    document.getElementById('numberOfRooms').value = numberOfRooms;
    document.getElementById('cancelModal').style.display = 'block';
}

function closeCancelModal() {
    console.log('Closing cancel modal');
    document.getElementById('cancelModal').style.display = 'none';
}

document.getElementById('cancelForm').addEventListener('submit', function(event) {
    event.preventDefault();
    console.log('Form submitted');
    var bookingId = document.getElementById('cancelBookingId').value;
    var cancelReason = document.getElementById('cancelReason').value;
    var numberOfRooms = document.getElementById('numberOfRooms').value;
    
    console.log('Sending cancellation request for booking ID:', bookingId);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'cancel_booking.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log('Cancellation successful');
            document.getElementById('cancelModal').style.display = 'none';
            document.getElementById('successMessage').style.display = 'block';
            setTimeout(function() {
                document.getElementById('successMessage').style.display = 'none';
            }, 3000);
            location.reload();
        } else if (xhr.readyState == 4) {
            console.error('Error:', xhr.responseText);
            alert('Error: ' + xhr.responseText);
        }
    };
    xhr.send('booking_id=' + bookingId + '&cancel_reason=' + encodeURIComponent(cancelReason) + '&number_of_rooms=' + numberOfRooms);
});
