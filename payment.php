<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Form</title>
    <link rel="icon" href="img/icon.jpg" >
    <link rel="stylesheet" href="css/payment.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Confirm Your Payment</h1>
        <div class="card-row">
            <div class="card-number">
                <h3>Card Number</h3>
                <div class="input-field card-number-field">
                    <input type="text" maxlength="4" class="card-input">
                    <input type="text" maxlength="4" class="card-input">
                    <input type="text" maxlength="4" class="card-input">
                    <input type="text" maxlength="4" class="card-input">
                </div>
            </div>
            <div class="cvv">
                <h3>CVV</h3>
                <div class="input-field">
                    <input type="text" maxlength="3" placeholder="CVV" id="cvv">
                </div>
            </div>
        </div>
        <div class="owner-row">
            <div class="owner">
                <h3>NAME</h3>
                <div class="input-field">
                    <input type="text" placeholder="Owner Name">
                </div>
            </div>
        </div>
        <div class="date-row">
            <div class="date">
                <h3>Expiration Date</h3>
                <div class="input-field">
                    <input type="text" maxlength="2" placeholder="MM" id="month">
                    <span>/</span>
                    <input type="text" maxlength="2" placeholder="YY" id="year">
                </div>
            </div>
            <div class="cards">
                <img src="img/mc.png" alt="MasterCard">
                <img src="img/vi.png" alt="Visa">
                <img src="img/pp.png" alt="PayPal">
            </div>
        </div>
        <button onclick="confirmPayment()">Confirm</button>
    </div>
    <script src="script/payment.js"></script>
</body>
</html>
