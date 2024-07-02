document.addEventListener('DOMContentLoaded', function() {
    fetch(`script/fetch_reservations.php?email=lieweden03@gmail.com`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                // Handle server-side errors
                console.error('Server error:', data.error);
                alert('An error occurred while fetching reservation data. Please try again later.');
                return;
            }

            const rowsContainer = document.getElementById('reservation-table');

            if (data.length === 0) {
                document.getElementById('no-reservation-message').style.display = 'block';
                document.querySelector('.reservation-table').style.display = 'none';
            } else {
                data.forEach(reservation => {
                    const row = document.createElement('div');
                    row.className = 'row';
                    row.innerHTML = `
                        <div class="cell">${reservation.reservation_id}</div>
                        <div class="cell">${reservation.check_in_date}</div>
                        <div class="cell">${reservation.check_out_date}</div>
                        <div class="cell">${reservation.number_of_guests}</div>
                        <div class="cell">${reservation.room_level}</div>
                        <div class="cell">${reservation.room_number}</div>
                        <div class="cell">${reservation.reservation_status}</div>
                    `;
                    rowsContainer.appendChild(row);
                });

                document.getElementById('no-reservation-message').style.display = 'none';
                document.querySelector('.reservation-table').style.display = 'flex'; // Show the table after populating data
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            alert('An error occurred while fetching reservation data. Please try again later.');
        });
});
