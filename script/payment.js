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
        if (yearInput.value.length > 2) {
            yearInput.value = yearInput.value.slice(0, 2);
        }
    });
});

function confirmPayment() {
    const year = document.getElementById('year').value;
    const fullYear = parseInt("20" + year);

    if (fullYear >= 2024) {
        window.location.href = "payment_success.html";
    } else {
        window.location.href = "payment_failure.html";
    }
}
