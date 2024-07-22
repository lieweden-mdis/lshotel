document.addEventListener("DOMContentLoaded", function() {
  function fetchData() {
      fetch('your-api-endpoint')
          .then(response => response.json())
          .then(data => {
              let totalBookingsElement = document.getElementById('total-bookings');
              let pendingBookingsElement = document.getElementById('pending-bookings');
              let completedBookingsElement = document.getElementById('completed-bookings');
              let cancelledBookingsElement = document.getElementById('cancelled-bookings');

              if (totalBookingsElement) {
                  totalBookingsElement.innerHTML = data.totalBookings;
              }

              if (pendingBookingsElement) {
                  pendingBookingsElement.innerHTML = data.pendingBookings;
              }

              if (completedBookingsElement) {
                  completedBookingsElement.innerHTML = data.completedBookings;
              }

              if (cancelledBookingsElement) {
                  cancelledBookingsElement.innerHTML = data.cancelledBookings;
              }
          })
          .catch(error => console.error('Error fetching data:', error));
  }

  fetchData();
});
