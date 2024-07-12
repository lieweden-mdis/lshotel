const roomPrices = {
    "Standard Room": 300,
    "Deluxe Room": 340,
    "Triple Room": 500,
    "Family Suite Room": 1000
};

function calculateDays() {
    const checkInDateValue = document.getElementById('check-in-date').value;
    const checkOutDateValue = document.getElementById('check-out-date').value;

    if (!checkInDateValue || !checkOutDateValue) {
        return;
    }

    const checkInDate = new Date(checkInDateValue);
    const checkOutDate = new Date(checkOutDateValue);

    if (checkOutDate < checkInDate) {
        return;
    }

    const timeDiff = checkOutDate.getTime() - checkInDate.getTime();
    const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
    const adjustedNightCount = dayDiff === 0 ? 1 : dayDiff;

    document.getElementById('day').value = adjustedNightCount;
    updatePriceDetails();
}

function generateRoomOptions() {
    const roomQuantity = parseInt(document.getElementById('room-quantity-input').value) || 0;
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
    } else {
        inputElement.disabled = true;
        inputElement.value = '';
        inputElement.placeholder = "No quantity required";
        inputElement.style.backgroundColor = "grey";
        inputElement.style.color = "#aaa";
    }
    updatePriceDetails();

    inputElement.addEventListener('input', function() {
        let value = this.value.trim();

        if (parseFloat(value) < 0) {
            this.value = '';
            return;
        }

        if (value.includes('e')) {
            const parts = value.split('e');
            if (parts.length !== 2 || isNaN(parts[1])) {
                this.value = '';
                return;
            }
        }
    });
}

function updatePriceDetails() {
    const checkInDateValue = document.getElementById('check-in-date').value;
    const checkOutDateValue = document.getElementById('check-out-date').value;

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
    const form = document.getElementById('booking-form');
    if (!form.checkValidity()) {
        event.preventDefault();
        form.reportValidity();
    } else {
        form.submit();
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

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('car-1').addEventListener('change', function() {
        toggleCarPlateField(this);
    });

    const addCarPlateButton = document.getElementById('add-car-plate-btn');
    addCarPlateButton.disabled = true;
    addCarPlateButton.classList.add('disabled');

    generateRoomOptions();

    document.getElementById('check-in-date').addEventListener('change', calculateDays);
    document.getElementById('check-out-date').addEventListener('change', calculateDays);
    document.getElementById('room-quantity-input').addEventListener('change', generateRoomOptions);

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

            if (parseFloat(value) < 0) {
                this.value = '';
                return;
            }

            if (value.includes('e')) {
                const parts = value.split('e');
                if (parts.length !== 2 || isNaN(parts[1])) {
                    this.value = '';
                    return;
                }
            }
        });
    });

    document.querySelectorAll('input[name^="breakfastquantity"]').forEach(input => {
        input.addEventListener('input', updatePriceDetails);
        input.addEventListener('input', function() {
            let value = this.value.trim();

            if (parseFloat(value) < 0) {
                this.value = '';
                return;
            }

            if (value.includes('e')) {
                const parts = value.split('e');
                if (parts.length !== 2 || isNaN(parts[1])) {
                    this.value = '';
                    return;
                }
            }
        });
    });
});

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
