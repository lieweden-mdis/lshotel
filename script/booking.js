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

document.getElementById('check-in-date').addEventListener('change', calculateDays);
        document.getElementById('check-out-date').addEventListener('change', calculateDays);

        function calculateDays() {
            // Get the values from the input fields
            const checkinDate = document.getElementById('check-in-date').value;
            const checkoutDate = document.getElementById('check-out-date').value;

            // Check if both dates are provided
            if (!checkinDate || !checkoutDate) {
                document.getElementById('day').value = '';
                return;
            }

            // Convert the date strings to Date objects
            const checkin = new Date(checkinDate);
            const checkout = new Date(checkoutDate);

            // Calculate the difference in time
            const diffTime = checkout - checkin;

            // Convert the difference in time to days
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            // Set the value of the "day" input field
            document.getElementById('day').value = diffDays > 0 ? diffDays : 0;
        }
        
    function toggleExtraBed(value) {
        var bedQuantityInput = document.getElementById('bedquantity');
        if (value === 'No') {
            bedQuantityInput.disabled = true;
            bedQuantityInput.style.backgroundColor = 'black';
            bedQuantityInput.placeholder = 'No extra bed quantity required';
            bedQuantityInput.value = '';
        } else {
            bedQuantityInput.disabled = false;
            bedQuantityInput.style.backgroundColor = '';
            bedQuantityInput.placeholder = 'Key in the extra bed quantity';
        }
    }

    function toggleBreakfast(value) {
        var breakfastQuantityInput = document.getElementById('breakfastquantity');
        if (value === 'No') {
            breakfastQuantityInput.disabled = true;
            breakfastQuantityInput.style.backgroundColor = 'black';
            breakfastQuantityInput.placeholder = 'No extra bed quantity required';
            breakfastQuantityInput.value = '';
        } else {
            breakfastQuantityInput.disabled = false;
            breakfastQuantityInput.style.backgroundColor = '';
            breakfastQuantityInput.placeholder = 'Key in the breakfast quantity';
        }
    }