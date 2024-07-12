<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Hotel">
    
    <!--Icon-->  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!--CSS Stylesheet-->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/booking.css">
    
    <title>L's HOTEL - PROFILE</title>
    <link rel="icon" href="img/icon.jpg">
    <style>
        .room-price-card {
            font-size: 1.5em;
            color: red;
            margin: 2%;
        }

        .car-plate-row {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .car-plate-label {
            margin-right: 10px;
        }

        .car-plate-row input {
            margin-right: 10px;
            padding: 5px;
        }

        .car-plate-row button {
            padding: 5px 10px;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
        }

        .car-plate-row button:hover {
            background-color: #d32f2f;
        }

        .disabled {
            background-color: grey;
            color: #aaa;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>   
    <!--Booking-->
    <div class="booking-header">
        <span>Booking Page</span>
    </div>
    
    <!--Container for flex-->
    <div class="booking-container">
        <div class="roomtype-card">
            <div class="room-type-box">
                <img id="room-image" src="img/room-image/default-room.jpg" alt="Room Image"/>
                <div class="room-type-info">
                    <div class="room-type-header">
                        <span id="room-type-name">Room Type</span>
                    </div>
                    <div class="room-price-card">
                       <span id="room-price">RM xxx per Room per Night</span>
                    </div>
                    <div class="room-features" id="room-features">
                        <span class="features-items"><i class="fa-solid fa-bed"></i> 1 Queen Bed / 2 Single Beds</span>
                        <span class="features-items"><i class="fa-solid fa-smoking"></i> Smoking / Non-Smoking</span>
                    </div>
                    <span class="size" id="room-size"><i class="fa-solid fa-up-right-and-down-left-from-center"></i> Room Size</span>
                    <span class="refund">Not Refundable</span>
                </div>
            </div>
            <form id="booking-form" action="process_booking.php" method="post" onsubmit="submitForm(event)">
                <div class="form-content">
                    <div class="booking-card">
                        <span class="form-header">Booking Information</span>
                        <div class="booking-info">
                            <div class="column" id="checkindate">
                                <label for="check-in-date">Check In Date</label>
                                <input type="date" id="check-in-date" name="check-in-date" required onchange="calculateDays()">
                            </div>
                            <div class="column" id="checkoutdate">
                                <label for="check-out-date">Check Out Date</label>
                                <input type="date" id="check-out-date" name="check-out-date" required onchange="calculateDays()">
                            </div>
                            <div class="column" id="dayofstay">
                                <label for="day">Day of Stay</label>
                                <input type="number" id="day" name="day" readonly>
                            </div>

                            <div class="column" id="room-quantity">
                                <label for="room-quantity-input">Room Quantity</label>
                                <input type="number" id="room-quantity-input" name="room-quantity" required onchange="checkAvailability()">
                            </div>

                            <div class="column" id="bed-selection">
                                <label for="bed">Bed Selection</label>
                                <select name="bed" id="bed" required>
                                    <option value="" selected disabled hidden></option>
                                </select>
                            </div>

                            <div class="column" id="smoke-selection">
                                <label for="smoke">Smoke?</label>
                                <select name="smoke" id="smoke" required>
                                    <option value="" selected disabled hidden></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="additional-requests-container"></div>

                    <div class="guest-card">
                        <span class="form-header">Guest Information</span>
                        <div class="row">
                            <div class="column">
                                <label for="fname">First Name</label>
                                <input type="text" name="fname" id="fname" required maxlength="128" placeholder="This is same with given name">
                            </div>
                            <div class="column">
                                <label for="lname">Last Name</label>
                                <input type="text" name="lname" id="lname" required maxlength="128" placeholder="This is your surname">
                            </div>
                        </div>

                        <div class="row">
                            <div class="column">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" placeholder="Please key in your email (If have)">
                            </div>
                            <div class="column">
                                <label for="phone">Phone Number</label>
                                <input type="text" name="phone" id="phone" required minlength="8" maxlength="11" placeholder="Example:0123456789">
                            </div>
                        </div>

                        <div class="row">
                            <div class="column">
                                <label for="car-1">Bring Car?</label>
                                <select name="car-1" id="car-1" required onchange="toggleCarPlateField(this)">
                                    <option value="" selected disabled hidden></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="column">
                                <button id="add-car-plate-btn" type="button" onclick="addCarPlateField()">Add Car Plate</button>
                            </div>
                        </div>
                        <div id="car-plate-container"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="price-card">
            <div class="priceinfo">
                <span class="price-title">Price Detail</span>
                <div class="product">
                    <div class="column">
                        <span id="stay-duration">0 Room @ 0 Night</span>
                        <span id="stay-price">RM 0</span>
                    </div>
                    <div id="additional-charges-container" class="column">
                        <span>Additional Charges</span>
                        <span id="additional-charges">RM 0</span>
                    </div>
                    <hr>
                    <div class="column">
                        <span>Total Amount</span>
                        <span id="total-amount">RM 0</span>
                    </div>
                </div>
            </div>
            <div class="remarks">
                <span class="remarks-header">Remarks</span>
                <span class="remarks-content">
                    Check-in time: 3 PM (early check in will be charge RM50 upon check in)
                    <br>
                    Check-out time: 1 PM (all customers must check out before this time)
                </span>
                <span class="remarks-content">
                    A RM 50 cleaning fee will be charged if smoking occurs in a non-smoking room.
                </span>
            </div>
            <div class="booking-button">
                <button id="submit-btn" type="submit">Submit Booking</button>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy;2024 L's Hotel  All Right Reserved.</p>
    </footer>

    <script src="script/booking.js" type="text/javascript"></script>
    <script>
        const roomPrices = {
            "Standard Room": 300,
            "Deluxe Room": 340,
            "Triple Room": 500,
            "Family Suite Room": 1000
        };

        function calculateDays() {
            const checkInDateValue = document.getElementById('check-in-date').value;
            const checkOutDateValue = document.getElementById('check-out-date').value;

            // Check if either date is not selected
            if (!checkInDateValue || !checkOutDateValue) {
                return; // Exit function if either date is not selected
            }

            const checkInDate = new Date(checkInDateValue);
            const checkOutDate = new Date(checkOutDateValue);

            // Validate check-in and check-out dates
            if (checkOutDate < checkInDate) {
                return;
            }

            // Calculate the number of nights stayed
            const timeDiff = checkOutDate.getTime() - checkInDate.getTime();
            const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

            // Adjust for the number of nights considering hotel stay rules
            const adjustedNightCount = dayDiff === 0 ? 1 : dayDiff;

            document.getElementById('day').value = adjustedNightCount;
            updatePriceDetails();
        }

        function generateRoomOptions() {
            const roomQuantity = parseInt(document.getElementById('room-quantity-input').value) || 0;
            const container = document.getElementById('additional-requests-container');
            container.innerHTML = ''; // Clear previous entries

            for (let i = 1; i <= roomQuantity; i++) {
                const roomDiv = document.createElement('div');
                roomDiv.classList.add('additional-request-card');
                roomDiv.innerHTML = `
                    <span class="form-header">Room ${i} - Additional Requests</span>
                    <div class="request-info">
                        <div class="column">
                            <label for="add-bed-${i}">Extra Bed</label>
                            <select name="add-bed-${i}" id="add-bed-${i}" required>
                                <option value="" selected disabled hidden></option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                
                        <div class="column">
                            <label for="bedquantity-${i}">Extra Bed Quantity</label>
                            <input type="number" id="bedquantity-${i}" name="bedquantity-${i}" placeholder="Select extra bed option first" disabled>
                        </div>
                
                        <div class="column">
                            <label for="add-breakfast-${i}">Add Breakfast</label>
                            <select name="add-breakfast-${i}" id="add-breakfast-${i}" required>
                                <option value="" selected disabled hidden></option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                
                        <div class="column">
                            <label for="breakfastquantity-${i}">Breakfast Quantity</label>
                            <input type="number" id="breakfastquantity-${i}" name="breakfastquantity-${i}" placeholder="Select breakfast option first" disabled>
                        </div>
                    </div>
                    <div class="additional-request-remarks">
                        <span id="additional-charges-remarks-text">Extra Bed: RM 10 per unit. Breakfast: RM 35 per person.</span>
                    </div>
                `;
                container.appendChild(roomDiv);

                // Add event listeners for the newly created elements
                document.getElementById(`add-bed-${i}`).addEventListener('change', function() {
                    toggleFieldState(this, `bedquantity-${i}`);
                });
                document.getElementById(`add-breakfast-${i}`).addEventListener('change', function() {
                    toggleFieldState(this, `breakfastquantity-${i}`);
                });
                document.getElementById(`bedquantity-${i}`).addEventListener('input', updatePriceDetails);
                document.getElementById(`breakfastquantity-${i}`).addEventListener('input', updatePriceDetails);
            }

            updatePriceDetails(); // Ensure initial update after generating options
            updateCarPlateButtonState(); // Update car plate button state
        }

        function toggleFieldState(selectElement, inputId) {
            const inputElement = document.getElementById(inputId);
            if (selectElement.value === 'Yes') {
                inputElement.disabled = false;
                inputElement.placeholder = "Please enter quantity";
                inputElement.style.backgroundColor = "";
                inputElement.style.color = "";
            } else {
                inputElement.disabled = true;
                inputElement.value = '';
                inputElement.placeholder = "No quantity required";
                inputElement.style.backgroundColor = "grey";
                inputElement.style.color = "#aaa";
            }
            updatePriceDetails(); // Update after toggle

            // Add input validation for numeric inputs
            inputElement.addEventListener('input', function() {
                let value = this.value.trim();

                // Prevent negative values
                if (parseFloat(value) < 0) {
                    this.value = ''; // Reset to empty string or previous valid value
                    return;
                }

                // Prevent scientific notation without valid exponent
                if (value.includes('e')) {
                    const parts = value.split('e');
                    if (parts.length !== 2 || isNaN(parts[1])) {
                        this.value = ''; // Reset to empty string or previous valid value
                        return;
                    }
                }
            });
        }

        function updatePriceDetails() {
            const checkInDateValue = document.getElementById('check-in-date').value;
            const checkOutDateValue = document.getElementById('check-out-date').value;

            // Hide stay details if either date is not selected
            if (!checkInDateValue || !checkOutDateValue) {
                document.getElementById('stay-duration').innerText = '';
                document.getElementById('stay-price').innerText = '';
                document.getElementById('additional-charges').style.display = 'none';
                document.getElementById('total-amount').innerText = '';
                return;
            }

            const roomType = document.getElementById('room-type-name').innerText.trim();
            const roomPrice = roomPrices[roomType] || 0;
            const extraBedPrice = 10;
            const breakfastPrice = 35;

            const days = parseInt(document.getElementById('day').value) || 0;
            const roomQuantity = parseInt(document.getElementById('room-quantity-input').value) || 0;

            let extraBedTotal = 0;
            let breakfastTotal = 0;

            for (let i = 1; i <= roomQuantity; i++) {
                const addBedSelect = document.getElementById(`add-bed-${i}`);
                const addBreakfastSelect = document.getElementById(`add-breakfast-${i}`);
                const bedQuantityInput = document.getElementById(`bedquantity-${i}`);
                const breakfastQuantityInput = document.getElementById(`breakfastquantity-${i}`);

                if (addBedSelect.value === 'Yes') {
                    const bedQuantity = parseInt(bedQuantityInput.value) || 0;
                    extraBedTotal += bedQuantity;
                }

                if (addBreakfastSelect.value === 'Yes') {
                    const breakfastQuantity = parseInt(breakfastQuantityInput.value) || 0;
                    breakfastTotal += breakfastQuantity;
                }
            }

            const stayPrice = roomPrice * roomQuantity * days;
            const additionalCharges = (extraBedTotal * extraBedPrice) + (breakfastTotal * breakfastPrice);

            document.getElementById('stay-duration').innerText = `${roomQuantity} Room${roomQuantity !== 1 ? 's' : ''} @ ${days} Night${days !== 1 ? 's' : ''}`;
            document.getElementById('stay-price').innerText = `RM ${stayPrice}`;

            const additionalChargesElement = document.getElementById('additional-charges');
            if (additionalCharges > 0) {
                additionalChargesElement.style.display = 'block';
                additionalChargesElement.innerText = `RM ${additionalCharges}`;
            } else {
                additionalChargesElement.style.display = 'none';
            }

            document.getElementById('total-amount').innerText = `RM ${stayPrice + additionalCharges}`;
        }

        function submitForm(event) {
            // Validate form using native HTML5 validation
            const form = document.getElementById('booking-form');
            if (!form.checkValidity()) {
                event.preventDefault(); // Prevent form submission if invalid
                form.reportValidity(); // Trigger native validation UI
            } else {
                form.submit(); // Submit the form if valid
            }
        }

        function toggleCarPlateField(selectElement) {
            const addCarPlateButton = document.getElementById('add-car-plate-btn');
            if (selectElement.value === 'Yes') {
                addCarPlateButton.disabled = false;
                addCarPlateButton.classList.remove('disabled');
            } else {
                addCarPlateButton.disabled = true;
                addCarPlateButton.classList.add('disabled');
                document.getElementById('car-plate-container').innerHTML = '';
            }
        }

        function addCarPlateField() {
            const container = document.getElementById('car-plate-container');
            const carPlateCount = container.childElementCount;
            const roomQuantity = parseInt(document.getElementById('room-quantity-input').value) || 0;

            if (carPlateCount >= roomQuantity) {
                alert(`You can only add up to ${roomQuantity} car plates.`);
                return;
            }

            const row = document.createElement('div');
            row.className = 'car-plate-row';

            const label = document.createElement('label');
            label.className = 'car-plate-label';
            label.innerText = `Car Plate Number ${carPlateCount + 1}`;
            row.appendChild(label);

            const input = document.createElement('input');
            input.type = 'text';
            input.placeholder = 'Enter Car Plate Number';
            input.required = true;
            row.appendChild(input);

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.innerText = 'Remove';
            removeButton.onclick = function() {
                container.removeChild(row);
                updateCarPlateButtonState(); // Update button state after removing a car plate
            };
            row.appendChild(removeButton);

            container.appendChild(row);
        }

        function updateCarPlateButtonState() {
            const bringCarSelect = document.getElementById('car-1');
            const addCarPlateButton = document.getElementById('add-car-plate-btn');
            const roomQuantity = parseInt(document.getElementById('room-quantity-input').value) || 0;
            const carPlateCount = document.getElementById('car-plate-container').childElementCount;

            if (bringCarSelect.value === 'Yes' && carPlateCount < roomQuantity) {
                addCarPlateButton.disabled = false;
                addCarPlateButton.classList.remove('disabled');
            } else {
                addCarPlateButton.disabled = true;
                addCarPlateButton.classList.add('disabled');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('car-1').addEventListener('change', function() {
                toggleCarPlateField(this);
            });

            const addCarPlateButton = document.getElementById('add-car-plate-btn');
            addCarPlateButton.disabled = true;
            addCarPlateButton.classList.add('disabled');

            // Initialize event listeners and generate room options
            generateRoomOptions();

            // Add event listeners for date inputs
            document.getElementById('check-in-date').addEventListener('change', calculateDays);
            document.getElementById('check-out-date').addEventListener('change', calculateDays);

            // Add event listener for room quantity input
            document.getElementById('room-quantity-input').addEventListener('change', generateRoomOptions);

            // Add event listeners for initial additional requests
            document.querySelectorAll('select[name^="add-bed"]').forEach(select => {
                select.addEventListener('change', function() {
                    const roomId = select.id.split('-')[2];
                    toggleFieldState(this, `bedquantity-${roomId}`);
                });
            });

            document.querySelectorAll('select[name^="add-breakfast"]').forEach(select => {
                select.addEventListener('change', function() {
                    const roomId = select.id.split('-')[2];
                    toggleFieldState(this, `breakfastquantity-${roomId}`);
                });
            });

            document.querySelectorAll('input[name^="bedquantity"]').forEach(input => {
                input.addEventListener('input', updatePriceDetails);
                input.addEventListener('input', function() {
                    let value = this.value.trim();

                    // Prevent negative values
                    if (parseFloat(value) < 0) {
                        this.value = ''; // Reset to empty string or previous valid value
                        return;
                    }

                    // Prevent scientific notation without valid exponent
                    if (value.includes('e')) {
                        const parts = value.split('e');
                        if (parts.length !== 2 || isNaN(parts[1])) {
                            this.value = ''; // Reset to empty string or previous valid value
                            return;
                        }
                    }
                });
            });

            document.querySelectorAll('input[name^="breakfastquantity"]').forEach(input => {
                input.addEventListener('input', updatePriceDetails);
                input.addEventListener('input', function() {
                    let value = this.value.trim();

                    // Prevent negative values
                    if (parseFloat(value) < 0) {
                        this.value = ''; // Reset to empty string or previous valid value
                        return;
                    }

                    // Prevent scientific notation without valid exponent
                    if (value.includes('e')) {
                        const parts = value.split('e');
                        if (parts.length !== 2 or isNaN(parts[1])) {
                            this.value = ''; // Reset to empty string or previous valid value
                            return;
                        }
                    }
                });
            });
        });

        function isValidEmail(email) {
            // Basic email validation using regex
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>
</body>
</html>
