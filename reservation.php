<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L's HOTEL - MY RESERVATION</title>
    <link rel="icon" href="img/icon.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/reservation.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="reservation-page">
        <div class="sidebar">
            <a href="profile.php">Profile</a>
            <a href="reservation.php">Reservation</a>
        </div> 

        <section class="reservation-grid">
            <h2>My Reservations</h2>
            <div id="booking-cards" class="booking-cards">
                <?php include 'fetch_customer_bookings.php'; ?>
            </div>
        </section>
    </div>

    <!-- Modal -->
    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-section">
                <h3>Booking Information</h3>
                <div class="modal-grid">
                    <div>
                        <label for="booking-id">Booking ID:</label>
                        <input type="text" id="booking-id" readonly>
                    </div>
                    <div>
                        <label for="booking-date">Booking Date:</label>
                        <input type="text" id="booking-date" readonly>
                    </div>
                    <div>
                        <label for="room-type">Room Type:</label>
                        <input type="text" id="room-type" readonly>
                    </div>
                    <div>
                        <label for="check-in-date">Check In Date:</label>
                        <input type="text" id="check-in-date" readonly>
                    </div>
                    <div>
                        <label for="check-out-date">Check Out Date:</label>
                        <input type="text" id="check-out-date" readonly>
                    </div>
                    <div>
                        <label for="stay-days">Days of Stay:</label>
                        <input type="text" id="stay-days" readonly>
                    </div>
                    <div>
                        <label for="room-quantity">Room Quantity:</label>
                        <input type="text" id="room-quantity" readonly>
                    </div>
                    <div>
                        <label for="bed-selection">Bed Selection:</label>
                        <input type="text" id="bed-selection" readonly>
                    </div>
                    <div>
                        <label for="smoke">Smoke:</label>
                        <input type="text" id="smoke" readonly>
                    </div>
                    <div>
                        <label for="total-amount">Total Amount Paid:</label>
                        <input type="text" id="total-amount" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-section">
                <h3>Additional Requests</h3>
                <div id="additional-charges" class="flex-container">
                    <div class="charge-item">
                        <div class="charge-header"><strong>Room 1 - Additional Requests</strong></div>
                        <div class="additional-requests-grid">
                            <div>
                                <label>Extra Bed:</label>
                                <input type="text" value="Yes" readonly>
                            </div>
                            <div>
                                <label>Extra Bed Quantity:</label>
                                <input type="text" value="1" readonly>
                            </div>
                            <div>
                                <label>Add Breakfast:</label>
                                <input type="text" value="Yes" readonly>
                            </div>
                            <div>
                                <label>Breakfast Quantity:</label>
                                <input type="text" value="1" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="charge-item">
                        <div class="charge-header"><strong>Room 2 - Additional Requests</strong></div>
                        <div class="additional-requests-grid">
                            <div>
                                <label>Extra Bed:</label>
                                <input type="text" value="Yes" readonly>
                            </div>
                            <div>
                                <label>Extra Bed Quantity:</label>
                                <input type="text" value="1" readonly>
                            </div>
                            <div>
                                <label>Add Breakfast:</label>
                                <input type="text" value="Yes" readonly>
                            </div>
                            <div>
                                <label>Breakfast Quantity:</label>
                                <input type="text" value="1" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-section">
                <h3>Guest Information</h3>
                <div class="modal-grid">
                    <div>
                        <label for="customer-name">Customer Name:</label>
                        <input type="text" id="customer-name" readonly>
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <input type="text" id="email" readonly>
                    </div>
                    <div>
                        <label for="phone">Phone Number:</label>
                        <input type="text" id="phone" readonly>
                    </div>
                    <div>
                        <label for="bring-car">Bring Car:</label>
                        <input type="text" id="bring-car" readonly>
                    </div>
                    <div>
                        <label for="car-plate">Car Plate Number:</label>
                        <input type="text" id="car-plate" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-actions">
                <button id="closeModal">Exit</button>
                <button id="viewRoomDetails">View Room Details</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy;2024 L's Hotel All Right Reserved.</p>
    </footer>

    <!-- Modal JavaScript -->
    <script>
// Get the modal
var modal = document.getElementById("bookingModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var closeModal = document.getElementById("closeModal");

// Variable to store the current booking data
var currentBookingData = null;

// Function to open the modal
function openModal(bookingData) {
    // Check if the modal is already open
    if (modal.style.display === "block") return;

    currentBookingData = bookingData;

    // Populate the modal fields with booking data
    document.getElementById("booking-id").value = bookingData.bookingId;
    document.getElementById("booking-date").value = bookingData.bookingDate;
    document.getElementById("room-type").value = bookingData.roomType;
    document.getElementById("check-in-date").value = bookingData.checkInDate;
    document.getElementById("check-out-date").value = bookingData.checkOutDate;
    document.getElementById("stay-days").value = bookingData.stayDays;
    document.getElementById("room-quantity").value = bookingData.roomQuantity;
    document.getElementById("bed-selection").value = bookingData.bedSelection;
    document.getElementById("smoke").value = bookingData.smoke;
    document.getElementById("total-amount").value = bookingData.totalAmount;
    document.getElementById("customer-name").value = bookingData.customerName;
    document.getElementById("email").value = bookingData.email;
    document.getElementById("phone").value = bookingData.phone;
    document.getElementById("bring-car").value = bookingData.bringCar;
    document.getElementById("car-plate").value = bookingData.carPlate;

    // Populate additional charges
    var additionalChargesContainer = document.getElementById("additional-charges");
    additionalChargesContainer.innerHTML = ""; // Clear previous content

    bookingData.additionalCharges.forEach(function(charge, index) {
        var chargeDiv = document.createElement("div");
        chargeDiv.className = 'charge-item';
        chargeDiv.innerHTML = `
            <div class="charge-header"><strong>Room ${index + 1} - Additional Requests</strong></div>
            <div class="additional-requests-grid">
                <div>
                    <label>Extra Bed:</label>
                    <input type="text" value="${charge.extraBed || 'N/A'}" readonly>
                </div>
                <div>
                    <label>Extra Bed Quantity:</label>
                    <input type="text" value="${charge.extraBedQuantity || 'N/A'}" readonly>
                </div>
                <div>
                    <label>Add Breakfast:</label>
                    <input type="text" value="${charge.addBreakfast || 'N/A'}" readonly>
                </div>
                <div>
                    <label>Breakfast Quantity:</label>
                    <input type="text" value="${charge.breakfastQuantity || 'N/A'}" readonly>
                </div>
            </div>`;
        additionalChargesContainer.appendChild(chargeDiv);
    });

    // Display the modal
    modal.style.display = "block";

    // Set the Room Details button link
    var roomDetailsButton = document.getElementById("viewRoomDetails");
    var roomDetailsPage;
    switch (bookingData.roomType) {
        case "Standard Room":
            roomDetailsPage = "standard-room.php";
            break;
        case "Deluxe Room":
            roomDetailsPage = "deluxe-room.php";
            break;
        case "Triple Room":
            roomDetailsPage = "triple-room.php";
            break;
        case "Family Suite Room":
            roomDetailsPage = "family-suite-room.php";
            break;
        default:
            roomDetailsPage = "#";
            break;
    }
    roomDetailsButton.onclick = function() {
        window.location.href = roomDetailsPage;
    }
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
    currentBookingData = null; // Clear booking data when modal is closed
}

closeModal.onclick = function() {
    modal.style.display = "none";
    currentBookingData = null; // Clear booking data when modal is closed
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        currentBookingData = null; // Clear booking data when modal is closed
    }
}

// Function to handle view details click
function handleViewDetailsClick(event) {
    var bookingData = JSON.parse(event.target.dataset.bookingData);
    openModal(bookingData);
}

// Attach event listeners to view details links
document.addEventListener('DOMContentLoaded', function() {
    var viewDetailsLinks = document.querySelectorAll('.view-details');
    viewDetailsLinks.forEach(function(link) {
        link.addEventListener('click', handleViewDetailsClick);
    });
});
    </script>
</body>
</html>
