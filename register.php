<?php
require 'header.php';
require 'config.php'; // Assuming you have a config.php for database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted form data
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'];

    // Basic validation
    if ($password != $confirmPassword) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Database connection
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone_number, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $phoneNumber, $hashedPassword);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!');</script>";
        } else {
            echo "<script>alert('Registration unsuccessful. Please try again.');</script>";
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Hotel">
    
    <!--Icon-->  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!--Font Family-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <!--CSS Stylesheet-->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/register.css">
    
    <title>L's HOTEL - REGISTER</title>
    <link rel="icon" href="img/icon.jpg">
</head>
<body>
    <div class="container"> 
        <!--Register Form-->
        <form action="register.php" method="POST" onsubmit="return validatePasswords()">
            <div class="register-form">
                <span class="form-header">User Registration</span>
                <div class="row">
                    <div class="input-data">
                        <label for="fname">First Name<i class="fa-solid fa-address-card"></i></label>
                        <input type="text" id="first-name" name="fname" placeholder="Enter your First Name" required>
                    </div>
                    <div class="input-data">
                        <label for="lname">Last Name<i class="fa-solid fa-address-card"></i></label>
                        <input type="text" id="last-name" name="lname" placeholder="Enter your Last Name" required>
                    </div>
                </div>
                <div class="row">
                    <div class="input-data">
                        <label for="email">Email<i class="fa-solid fa-envelope"></i></label>
                        <input type="email" id="email" name="email" placeholder="Enter your Email" required>
                    </div>
                    <div class="input-data">
                        <label for="phone">Phone Number<i class="fa-solid fa-phone"></i></label>
                        <input type="text" id="phone-number" name="phone" placeholder="Enter your Phone Number" required>
                    </div>
                </div>
                <div class="row">
                    <div class="input-data">
                        <label for="password">Password<i class="fa-solid fa-key"></i></label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="input-data">
                        <label for="confirm">Confirm Password<i class="fa-solid fa-key"></i></label>
                        <input type="password" id="confirm-password" name="confirmpassword" placeholder="Confirm your password" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Register">
                    <span>Already have an account? Sign In <a href="login.php">Here</a>!</span>
                </div>
            </div>
        </form>
    </div> 
    <!--Footer-->
    <footer>
        <p>&copy;2024 L's Hotel  All Right Reserved.</p>
    </footer>
</body>
<!--Javascript-->
<script src="script/register.js" type="text/javascript"></script>
<script>
function validatePasswords() {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm-password').value;
    if (password != confirmPassword) {
        alert('Passwords do not match. Please try again.');
        return false;
    }
    return true;
}
</script>
</html>
