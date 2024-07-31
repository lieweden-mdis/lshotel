document.addEventListener("DOMContentLoaded", function() {
    const cardInputs = document.querySelectorAll('.card-input');

    cardInputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            if (input.value.length === 4 && index < cardInputs.length - 1) {
                cardInputs[index + 1].focus();
            }
        });

        input.addEventListener('invalid', () => {
            input.setCustomValidity("Please enter exactly 4 digits.");
        });

        input.addEventListener('input', () => {
            input.setCustomValidity("");
        });
    });

    const monthInput = document.getElementById('month');
    monthInput.addEventListener('invalid', () => {
        monthInput.setCustomValidity("Please enter a valid month (01-12).");
    });
    monthInput.addEventListener('input', () => {
        monthInput.setCustomValidity("");
    });

    const yearInput = document.getElementById('year');
    yearInput.addEventListener('invalid', () => {
        yearInput.setCustomValidity("Please enter a valid year (e.g., 2025).");
    });
    yearInput.addEventListener('input', () => {
        yearInput.setCustomValidity("");
    });

    const cvvInput = document.getElementById('cvv');
    cvvInput.addEventListener('invalid', () => {
        cvvInput.setCustomValidity("Please enter 3 or 4 digits for CVV.");
    });
    cvvInput.addEventListener('input', () => {
        cvvInput.setCustomValidity("");
    });
});

function validatePayment() {
    const card1 = document.getElementById('card1').value;
    const card2 = document.getElementById('card2').value;
    const card3 = document.getElementById('card3').value;
    const card4 = document.getElementById('card4').value;
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;
    const cvv = document.getElementById('cvv').value;
    const owner = document.getElementById('owner').value;
    const bookingId = document.getElementById('booking_id').value;

    const fullYear = parseInt(year);

    // Get current date
    const currentDate = new Date();
    const currentMonth = currentDate.getMonth() + 1;
    const currentYear = currentDate.getFullYear();

    // Validate card number
    if (card1.length !== 4 || card2.length !== 4 || card3.length !== 4 || card4.length !== 4) {
        window.location.href = `payment_failure.php?booking_id=${bookingId}`;
        return false;
    }

    // Validate expiration date
    if (fullYear < currentYear || (fullYear === currentYear && parseInt(month) < currentMonth)) {
        window.location.href = `payment_failure.php?booking_id=${bookingId}`;
        return false;
    }

    // Validate CVV
    if (cvv.length < 3 || cvv.length > 4) {
        window.location.href = `payment_failure.php?booking_id=${bookingId}`;
        return false;
    }

    // Validate Owner Name
    if (owner.trim() === '') {
        window.location.href = `payment_failure.php?booking_id=${bookingId}`;
        return false;
    }

    // Redirect to payment success page
    window.location.href = `payment_success.php?booking_id=${bookingId}`;
    return false;
}
