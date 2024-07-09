function submitForm() {
    var checkInDate = new Date(document.getElementById("check-in-date").value);
    var checkOutDate = new Date(document.getElementById("check-out-date").value);
    
    if (checkInDate > checkOutDate) {
        alert("Check-in date must be before the check-out date.");
        return false;
    }

    var carSelect = document.getElementById("car-plate");
    var carPlateInput = document.querySelector('input[name="car-plate"]');
    
    if (carSelect.value === "Yes") {
        if (!carPlateInput.value.trim()) {
            alert("Please enter your car plate number.");
            return false;
        }
    }

    var form = document.getElementById("booking-form");
    if (form.checkValidity()) {
        form.submit();
    } else {
        form.reportValidity();
    }
}

// Car plate number enable/disable logic
document.addEventListener('DOMContentLoaded', function() {
    var carSelect = document.getElementById("car-plate");
    var carPlateInput = document.querySelector('input[name="car-plate"]');

    carSelect.addEventListener('change', function() {
        if (carSelect.value === "Yes") {
            carPlateInput.disabled = false;
            carPlateInput.style.backgroundColor = "";
            carPlateInput.style.color = "";
            carPlateInput.placeholder = "Please enter your car plate number";
        } else {
            carPlateInput.disabled = true;
            carPlateInput.style.backgroundColor = "black";
            carPlateInput.style.color = "white";
            carPlateInput.placeholder = "No car plate required";
            carPlateInput.value = ""; // Clear the input if disabled
        }
    });

    // Initial state check
    if (carSelect.value !== "Yes") {
        carPlateInput.disabled = true;
        carPlateInput.style.backgroundColor = "black";
        carPlateInput.style.color = "white";
        carPlateInput.placeholder = "No car plate required";
    }
});