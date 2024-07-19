document.addEventListener("DOMContentLoaded", function() {
    const cardInputs = document.querySelectorAll('.card-input');
    const cvvInput = document.getElementById('cvv');
    const monthInput = document.getElementById('month');
    const yearInput = document.getElementById('year');

    cardInputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            if (input.value.length === 4 && index < cardInputs.length - 1) {
                cardInputs[index + 1].focus();
            }
        });
    });

    cvvInput.addEventListener('input', () => {
        if (cvvInput.value.length > 3) {
            cvvInput.value = cvvInput.value.slice(0, 3);
        }
    });

    monthInput.addEventListener('input', () => {
        if (monthInput.value.length > 2) {
            monthInput.value = monthInput.value.slice(0, 2);
        }
    });

    yearInput.addEventListener('input', () => {
        if (yearInput.value.length > 4) {
            yearInput.value = yearInput.value.slice(0, 4);
        }
    });
});

function confirmPayment() {
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;
    const fullYear = parseInt(year);
    const bookingId = document.getElementById('booking_id').value;

    // Get current date
    const currentDate = new Date();
    const currentMonth = currentDate.getMonth() + 1; // getMonth() returns month index from 0-11
    const currentYear = currentDate.getFullYear();

    // Validate the expiration date
    if (fullYear > currentYear || (fullYear === currentYear && month >= currentMonth)) {
        window.location.href = `payment_success.php?booking_id=${bookingId}`;
    } else {
        window.location.href = `payment_failure.php?booking_id=${bookingId}`;
    }
}
