<?php
session_start();
require 'config.php'; // Include the database configuration file

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

// Check if the user is logged in
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$userDetails = [];
$user_email = '';

if ($user) {
    $sql = "SELECT first_name, last_name, email, phone_number FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $userDetails = $result->fetch_assoc();
        $user_email = $userDetails['email'];
    }
    $stmt->close();
}

$room_type = isset($_GET['roomType']) ? sanitizeInput($_GET['roomType']) : 'Default Room';

// Fetch room details from the database
$sql = "SELECT * FROM rooms WHERE room_type = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $room_type);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $price = $row['room_price'];
    $features = explode(',', $row['room_features']);
    $size = $row['room_size'];
    $availability = $row['room_availability'];
    $bed_options = isset($row['bed_options']) ? explode(',', $row['bed_options']) : []; // Ensure bed_options is set
    $images = explode(',', $row['room_images']);
    $image = isset($images[0]) ? 'img/room-image/' . strtolower(str_replace(' ', '-', $room_type)) . '/' . htmlspecialchars(trim($images[0])) : 'img/room-image/default-room.jpg';
} else {
    $room_type = 'Default Room';
    $price = 'xxx';
    $features = [];
    $size = 'N/A';
    $availability = 0;
    $bed_options = []; // No bed options available for default room
    $image = 'img/room-image/default-room.jpg';
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L's HOTEL - BOOKING</title>
    <link rel="icon" href="img/icon.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/booking.css">
    <style>
        .booking-container {
            display: flex;
            margin-left: 2%;
            margin-right: 2%;
}
        .room-type-box img#room-image {
            width: 15em;
            height: 15em;
        }

        .room-type-box .room-price-card {
            color: black;
            font-weight: bold;
            font-size: 1.5em;
            margin: 0 2% 0 2%;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="booking-header">
        <span>Booking Page</span>
    </div>

    <div class="booking-container">
        <div class="roomtype-card">
            <div class="room-type-box">
                <img id="room-image" src="<?php echo $image; ?>" alt="Room Image"/>
                <div class="room-type-info">
                    <div class="room-type-header">
                        <span id="room-type-name"><?php echo htmlspecialchars($room_type); ?></span>
                    </div>
                    <div class="room-price-card">
                        <span id="room-price">RM <?php echo htmlspecialchars($price); ?> per Room per Night</span>
                        <span id="room-availability">Room Availability: <?php echo htmlspecialchars($availability); ?></span>
                    </div>
                    <div class="room-features" id="room-features">
                        <?php
                        foreach ($features as $feature) {
                            echo '<span class="feature-item">' . htmlspecialchars($feature) . '</span>';
                        }
                        ?>
                    </div>
                    <span class="size" id="room-size"><i class="fa-solid fa-up-right-and-down-left-from-center"></i> <?php echo htmlspecialchars($size); ?></span>
                    <span class="refund">Not Refundable</span>
                </div>
            </div>
            <form id="booking-form" action="process_booking.php" method="post" onsubmit="validateForm(event)">
                <input type="hidden" name="room_type" value="<?php echo htmlspecialchars($room_type); ?>">
                <input type="hidden" name="total-amount" id="hidden-total-amount">
                <div class="form-content">
                    <div class="booking-card">
                        <span class="form-header">Booking Information</span>
                        <div class="booking-info">
                            <div class="column" id="checkindate">
                                <label for="check-in-date">Check In Date</label>
                                <input type="date" id="check-in-date" name="check-in-date" required>
                            </div>
                            <div class="column" id="checkoutdate">
                                <label for="check-out-date">Check Out Date</label>
                                <input type="date" id="check-out-date" name="check-out-date" required>
                            </div>
                            <div class="column" id="dayofstay">
                                <label for="day">Day of Stay</label>
                                <input type="number" id="day" name="day" readonly min="1">
                            </div>

                            <div class="column" id="room-quantity">
                                <label for="room-quantity-input">Room Quantity</label>
                                <input type="number" id="room-quantity-input" name="room-quantity" required min="1">
                            </div>

                            <div class="column" id="bed-selection">
                                <label for="bed">Bed Selection</label>
                                <select name="bed" id="bed" required>
                                    <option value="" selected disabled hidden></option>
                                    <?php
                                    foreach ($bed_options as $option) {
                                        echo '<option value="' . htmlspecialchars($option) . '">' . htmlspecialchars($option) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="column" id="smoke-selection">
                                <label for="smoke">Smoke?</label>
                                <select name="smoke" id="smoke" required>
                                    <option value="" selected disabled hidden></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
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
                                <input type="text" name="fname" id="fname" required maxlength="128" placeholder="This is same with given name" value="<?php echo isset($userDetails['first_name']) ? htmlspecialchars($userDetails['first_name']) : ''; ?>">
                            </div>
                            <div class="column">
                                <label for="lname">Last Name</label>
                                <input type="text" name="lname" id="lname" required maxlength="128" placeholder="This is your surname" value="<?php echo isset($userDetails['last_name']) ? htmlspecialchars($userDetails['last_name']) : ''; ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="column">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" placeholder="Please key in your email" value="<?php echo htmlspecialchars($user_email); ?>" <?php echo $user_email ? 'readonly' : ''; ?>>
                            </div>
                            <div class="column">
                                <label for="phone">Phone Number</label>
                                <input type="text" name="phone" id="phone" required minlength="8" maxlength="15" placeholder="Example:0123456789" value="<?php echo isset($userDetails['phone_number']) ? htmlspecialchars($userDetails['phone_number']) : ''; ?>">
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
                <button id="submit-btn" type="submit" onclick="validateForm(event)">Submit Booking</button>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy;2024 L's Hotel  All Right Reserved.</p>
    </footer>

    <script>
        let roomPrice = <?php echo json_encode($price); ?>; // Get the price from PHP
        const userDetails = <?php echo json_encode($userDetails); ?>; // Pass user details to JavaScript

        function fetchRoomDetails(roomType) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch-room-details.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const roomDetails = JSON.parse(xhr.responseText);
                    updateRoomDetails(roomDetails);
                } else {
                    console.error('Failed to fetch room details: ' + xhr.statusText);
                }
            };
            xhr.onerror = function() {
                console.error('Error during the AJAX request.');
            };
            xhr.send('room_type=' + encodeURIComponent(roomType) + '&response_type=json');
        }

        function updateRoomDetails(roomDetails) {
            document.getElementById('room-type-name').textContent = roomDetails.name;
            document.getElementById('room-price').textContent = 'RM ' + roomDetails.price + ' per Room per Night';
            document.getElementById('room-availability').textContent = 'Room Availability: ' + roomDetails.availability;
            document.getElementById('room-size').textContent = roomDetails.size;
            document.getElementById('room-image').src = roomDetails.image;
            roomPrice = roomDetails.price;

            const featuresContainer = document.getElementById('room-features');
            featuresContainer.innerHTML = '';
            roomDetails.features.forEach(feature => {
                const featureElement = document.createElement('span');
                featureElement.textContent = feature;
                featuresContainer.appendChild(featureElement);
            });

            const bedSelect = document.getElementById('bed');
            bedSelect.innerHTML = '<option value="" selected disabled hidden></option>';
            roomDetails.bed_options.forEach(bed => {
                const option = document.createElement('option');
                option.value = bed;
                option.textContent = bed;
                bedSelect.appendChild(option);
            });

            const smokeSelect = document.getElementById('smoke');
            smokeSelect.innerHTML = '<option value="" selected disabled hidden></option>';
            roomDetails.smoking_options.forEach(smoke => {
                const option = document.createElement('option');
                option.value = smoke;
                option.textContent = smoke;
                smokeSelect.appendChild(option);
            });

            updatePriceDetails();
        }

        function calculateDays() {
            const checkInDateValue = document.getElementById('check-in-date').value;
            const checkOutDateValue = document.getElementById('check-out-date').value;

            if (!checkInDateValue || !checkOutDateValue) {
                return;
            }

            const checkInDate = new Date(checkInDateValue);
            const checkOutDate = new Date(checkOutDateValue);

            if (checkOutDate < checkInDate) {
                alert("Check-out date must be after the check-in date.");
                document.getElementById('check-out-date').value = '';
                document.getElementById('day').value = '';
                return;
            }

            const timeDiff = checkOutDate.getTime() - checkInDate.getTime();
            let dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

            if (dayDiff === 0) {
                dayDiff = 1;
            }

            document.getElementById('day').value = dayDiff;
            updatePriceDetails();
        }

        function validateRoomQuantity() {
            const roomQuantityInput = document.getElementById('room-quantity-input');
            const roomQuantity = parseInt(roomQuantityInput.value) || 0;
            const roomAvailability = parseInt(document.getElementById('room-availability').textContent.split(' ')[2]) || 0;

            if (roomQuantity === 0) {
                alert("You must at least book for 1 room.");
                roomQuantityInput.value = '';
                return;
            }

            if (roomQuantity > roomAvailability) {
                alert(`You can only book up to ${roomAvailability} rooms.`);
                roomQuantityInput.value = '';
                return;
            }

            generateRoomOptions();
        }

        function generateRoomOptions() {
            const roomQuantityInput = document.getElementById('room-quantity-input');
            const roomQuantity = parseInt(roomQuantityInput.value) || 0;

            const container = document.getElementById('additional-requests-container');
            container.innerHTML = '';

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
                            <input type="number" id="bedquantity-${i}" name="bedquantity-${i}" required placeholder="Select extra bed option" disabled min="0">
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
                            <input type="number" id="breakfastquantity-${i}" name="breakfastquantity-${i}" required placeholder="Select breakfast option" disabled min="0">
                        </div>
                    </div>
                    <div class="additional-request-remarks">
                        <span id="additional-charges-remarks-text">Extra Bed: RM 10 per unit. Breakfast: RM 35 per person.</span>
                    </div>
                `;
                container.appendChild(roomDiv);

                document.getElementById(`add-bed-${i}`).addEventListener('change', function() {
                    toggleFieldState(this, `bedquantity-${i}`);
                });
                document.getElementById(`add-breakfast-${i}`).addEventListener('change', function() {
                    toggleFieldState(this, `breakfastquantity-${i}`);
                });
                document.getElementById(`bedquantity-${i}`).addEventListener('input', updatePriceDetails);
                document.getElementById(`breakfastquantity-${i}`).addEventListener('input', updatePriceDetails);
            }

            updatePriceDetails();
            updateCarPlateButtonState();
        }

        function toggleFieldState(selectElement, inputId) {
            const inputElement = document.getElementById(inputId);
            if (selectElement.value === 'Yes') {
                inputElement.disabled = false;
                inputElement.placeholder = "Please enter quantity";
                inputElement.style.backgroundColor = "";
                inputElement.style.color = "";
                inputElement.min = 1;
            } else {
                inputElement.disabled = true;
                inputElement.value = '';
                inputElement.placeholder = "No quantity required";
                inputElement.style.backgroundColor = "#CBCCCC";
                inputElement.style.color = "black";
                inputElement.min = 0;
            }
            updatePriceDetails();
        }

        function updatePriceDetails() {
            const checkInDateValue = document.getElementById('check-in-date').value;
            const checkOutDateValue = document.getElementById('check-out-date').value;
            const roomQuantity = parseInt(document.getElementById('room-quantity-input').value) || 0;

            if (!checkInDateValue || !checkOutDateValue || roomQuantity === 0) {
                document.getElementById('stay-duration').innerText = '';
                document.getElementById('stay-price').innerText = '';
                document.getElementById('additional-charges').style.display = 'none';
                document.getElementById('total-amount').innerText = '';
                return;
            }

            const days = parseInt(document.getElementById('day').value) || 0;

            let extraBedTotal = 0;
            let breakfastTotal = 0;

            for (let i = 1; i <= roomQuantity; i++) {
                const addBedSelect = document.getElementById(`add-bed-${i}`);
                const addBreakfastSelect = document.getElementById(`add-breakfast-${i}`);
                const bedQuantityInput = document.getElementById(`bedquantity-${i}`);
                const breakfastQuantityInput = document.getElementById(`breakfastquantity-${i}`);

                if (addBedSelect && addBedSelect.value === 'Yes') {
                    const bedQuantity = parseInt(bedQuantityInput.value) || 0;
                    extraBedTotal += bedQuantity;
                }

                if (addBreakfastSelect && addBreakfastSelect.value === 'Yes') {
                    const breakfastQuantity = parseInt(breakfastQuantityInput.value) || 0;
                    breakfastTotal += breakfastQuantity;
                }
            }

            const stayPrice = roomPrice * roomQuantity * days;
            const additionalCharges = (extraBedTotal * 10) + (breakfastTotal * 35);

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

        function validateForm(event) {
            const form = document.getElementById('booking-form');
            const totalAmount = document.getElementById('total-amount').innerText.replace('RM ', '');

            document.getElementById('hidden-total-amount').value = totalAmount;

            const checkInDateValue = document.getElementById('check-in-date').value;
            const checkOutDateValue = document.getElementById('check-out-date').value;
            const phoneValue = document.getElementById('phone').value;
            const roomQuantity = parseInt(document.getElementById('room-quantity-input').value) || 0;

            for (let i = 1; i <= roomQuantity; i++) {
                const addBedSelect = document.getElementById(`add-bed-${i}`);
                const addBreakfastSelect = document.getElementById(`add-breakfast-${i}`);
                const bedQuantityInput = document.getElementById(`bedquantity-${i}`);
                const breakfastQuantityInput = document.getElementById(`breakfastquantity-${i}`);

                if (addBedSelect && addBedSelect.value === 'Yes' && bedQuantityInput.value < 1) {
                    alert("You must add at least 1 bed.");
                    event.preventDefault();
                    return false;
                }

                if (addBreakfastSelect && addBreakfastSelect.value === 'Yes' && breakfastQuantityInput.value < 1) {
                    alert("You must add at least 1 breakfast.");
                    event.preventDefault();
                    return false;
                }
            }

            if (!form.checkValidity()) {
                event.preventDefault();
                form.reportValidity();
                return false;
            }

            if (new Date(checkOutDateValue) <= new Date(checkInDateValue)) {
                alert("Check-out date must be after the check-in date.");
                event.preventDefault();
                return false;
            }

            if (!isValidPhoneNumber(phoneValue)) {
                alert("Please enter a valid phone number.");
                event.preventDefault();
                return false;
            }

            const carPlateInputs = document.querySelectorAll('#car-plate-container input[type="text"]');
            carPlateInputs.forEach(input => {
                if (!input.value.trim()) {
                    alert("Please enter all car plate numbers.");
                    event.preventDefault();
                    return false;
                }
            });

            form.submit();
        }

        function isValidPhoneNumber(phone) {
            const phoneRegex = /^[0-9]{8,15}$/;
            return phoneRegex.test(phone);
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
            input.name = `car_plate_${carPlateCount + 1}`; // Add name attribute for form submission
            input.placeholder = 'Enter Car Plate Number';
            input.required = true;
            row.appendChild(input);

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.innerText = 'Remove';
            removeButton.onclick = function() {
                container.removeChild(row);
                updateCarPlateButtonState();
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

        function ensurePositiveValues() {
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value < this.min) {
                        this.value = this.min;
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (userDetails && Object.keys(userDetails).length > 0) {
                document.getElementById('fname').value = userDetails.first_name || '';
                document.getElementById('lname').value = userDetails.last_name || '';
                document.getElementById('email').value = userDetails.email || '';
                document.getElementById('phone').value = userDetails.phone_number || '';
            }

            document.getElementById('car-1').addEventListener('change', function() {
                toggleCarPlateField(this);
            });

            const addCarPlateButton = document.getElementById('add-car-plate-btn');
            addCarPlateButton.disabled = true;
            addCarPlateButton.classList.add('disabled');

            generateRoomOptions();
            ensurePositiveValues();

            document.getElementById('check-in-date').addEventListener('change', calculateDays);
            document.getElementById('check-out-date').addEventListener('change', calculateDays);

            const roomQuantityInput = document.getElementById('room-quantity-input');
            roomQuantityInput.addEventListener('change', validateRoomQuantity);

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
            });

            document.querySelectorAll('input[name^="breakfastquantity"]').forEach(input => {
                input.addEventListener('input', updatePriceDetails);
            });

            const urlParams = new URLSearchParams(window.location.search);

            const roomType = urlParams.get('roomType');
            const roomQuantity = urlParams.get('roomQuantity');
            const checkInDate = urlParams.get('checkInDate');
            const checkOutDate = urlParams.get('checkOutDate');

            if (roomType) {
                document.getElementById('room-type-name').textContent = roomType;
                fetchRoomDetails(roomType);
            }
            if (roomQuantity) {
                document.getElementById('room-quantity-input').value = roomQuantity;
                validateRoomQuantity();
            }
            if (checkInDate) {
                document.getElementById('check-in-date').value = checkInDate;
                calculateDays();
            }
            if (checkOutDate) {
                document.getElementById('check-out-date').value = checkOutDate;
                calculateDays();
            }
        });
    </script>
</body>
</html>
