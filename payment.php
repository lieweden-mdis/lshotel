<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Form</title>
    <link rel="icon" href="img/icon.jpg">
    <link rel="stylesheet" href="css/payment.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Confirm Your Payment</h1>
        <form id="paymentForm" onsubmit="return validatePayment()">
            <div class="card-row">
                <div class="card-number">
                    <label for="card1">Card Number</label>
                    <div class="input-field card-number-field">
                        <input type="text" maxlength="4" pattern="\d{4}" class="card-input" id="card1" required>
                        <input type="text" maxlength="4" pattern="\d{4}" class="card-input" id="card2" required>
                        <input type="text" maxlength="4" pattern="\d{4}" class="card-input" id="card3" required>
                        <input type="text" maxlength="4" pattern="\d{4}" class="card-input" id="card4" required>
                    </div>
                </div>
                <div class="cvv">
                    <label for="cvv">CVV</label>
                    <div class="input-field">
                        <input type="text" maxlength="4" pattern="\d{3,4}" id="cvv" required>
                    </div>
                </div>
            </div>
            <div class="owner-row">
                <div class="owner">
                    <label for="owner">NAME</label>
                    <div class="input-field">
                        <input type="text" placeholder="Owner Name" id="owner" required>
                    </div>
                </div>
            </div>
            <div class="date-row">
                <div class="date">
                    <label for="month">Expiration Date</label>
                    <div class="input-field">
                        <input type="text" maxlength="2" pattern="(0[1-9]|1[0-2])" placeholder="MM" id="month" required>
                        <span>/</span>
                        <input type="text" maxlength="4" pattern="\d{4}" placeholder="YYYY" id="year" required>
                    </div>
                </div>
                <div class="cards">
                    <img src="img/mc.png" alt="MasterCard">
                    <img src="img/vi.png" alt="Visa">
                    <img src="img/pp.png" alt="PayPal">
                </div>
            </div>
            <input type="hidden" id="booking_id" name="booking_id" value="<?php echo htmlspecialchars($_GET['booking_id']); ?>">
            <button type="submit">Confirm</button>
        </form>
    </div>

    <script src="script/payment.js"></script>
</body>
</html>
