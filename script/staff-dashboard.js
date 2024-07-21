function fetchData() {
    fetch('fetch_dashboard_data.php')
      .then(response => response.json())
      .then(data => {
        // Update room availability
        const roomAvailabilityContainer = document.getElementById('room-availability-container');
        roomAvailabilityContainer.innerHTML = '';
        for (const roomType in data.room_availability) {
          const card = document.createElement('div');
          card.className = 'card';
          card.innerHTML = `<h3>${roomType}</h3><p>${data.room_availability[roomType]}</p>`;
          roomAvailabilityContainer.appendChild(card);
        }
  
        // Update booking overview
        document.getElementById('total-bookings').textContent = data.total_bookings;
        document.getElementById('completed-bookings').textContent = data.completed_bookings;
        document.getElementById('pending-bookings').textContent = data.pending_bookings;
        document.getElementById('cancelled-bookings').textContent = data.cancelled_bookings;
  
        // Update recent bookings
        const recentBookingsTableBody = document.getElementById('recent-bookings-table-body');
        recentBookingsTableBody.innerHTML = '';
        data.recent_bookings.forEach(booking => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${booking.booking_id}</td>
            <td>${booking.customer_name}</td>
            <td>${booking.room_type}</td>
            <td>${booking.check_in_date}</td>
            <td>${booking.check_out_date}</td>
            <td>${booking.number_of_rooms}</td>
          `;
          recentBookingsTableBody.appendChild(row);
        });
      })
      .catch(error => console.error('Error fetching data:', error));
  }
  
  // Fetch data every 5 seconds
  setInterval(fetchData, 1000);
  
  // Initial fetch
  fetchData();
  