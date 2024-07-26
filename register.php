<?php
require 'header.php';
require 'config.php';

function checkDuplicateEmail($conn, $email) {
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $isDuplicate = $stmt->num_rows > 0;
    $stmt->close();
    return $isDuplicate;
}

function checkDuplicatePhone($conn, $phoneNumber) {
    $stmt = $conn->prepare("SELECT phone_number FROM users WHERE phone_number = ?");
    $stmt->bind_param("s", $phoneNumber);
    $stmt->execute();
    $stmt->store_result();
    $isDuplicate = $stmt->num_rows > 0;
    $stmt->close();
    return $isDuplicate;
}

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'];

    if ($password != $confirmPassword) {
        $errorMessage = "Passwords do not match. Please try again.";
    } else {
        $duplicateEmail = checkDuplicateEmail($conn, $email);
        $duplicatePhone = checkDuplicatePhone($conn, $phoneNumber);

        if ($duplicateEmail && $duplicatePhone) {
            $errorMessage = "Both email and phone number are registered with our record, please try again.";
            $email = ""; // Clear email input
            $phoneNumber = ""; // Clear phone number input
        } elseif ($duplicateEmail) {
            $errorMessage = "Email is registered with our record, please try another email.";
            $email = ""; // Clear email input
        } elseif ($duplicatePhone) {
            $errorMessage = "Phone number is registered with our record, please try another phone number.";
            $phoneNumber = ""; // Clear phone number input
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone_number, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $firstName, $lastName, $email, $phoneNumber, $hashedPassword);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $errorMessage = "Registration unsuccessful. Please try again.";
            }

            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/register.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container"> 
        <form action="" method="POST" id="registerForm">
            <div class="register-form">
                <span class="form-header">User Registration</span>
                <?php if (!empty($errorMessage)): ?>
                    <div class="message error-message"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                             <div class="row">
                    <div class="input-data">
                        <label for="fname">First Name<i class="fa-solid fa-address-card"></i></label>
                        <input type="text" id="first-name" name="fname" placeholder="Enter your First Name" value="<?php echo isset($firstName) ? $firstName : NULL; ?>" required>
                    </div>
                    <div class="input-data">
                        <label for="lname">Last Name<i class="fa-solid fa-address-card"></i></label>
                        <input type="text" id="last-name" name="lname" placeholder="Enter your Last Name" value="<?php echo isset($lastName) ? $lastName : NULL; ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="input-data">
                        <label for="email">Email<i class="fa-solid fa-envelope"></i></label>
                        <input type="email" id="email" name="email" placeholder="Enter your Email" value="<?php echo isset($email) ? $email : NULL; ?>" required>
                    </div>
                    <div class="input-data">
                        <label for="phone">Phone Number<i class="fa-solid fa-phone"></i></label>
                        <input type="text" id="phone-number" name="phone" placeholder="Enter your Phone Number" value="<?php echo isset($phoneNumber) ? $phoneNumber : NULL; ?>" required pattern="\d{8,11}" title="Phone number should be 8 to 11 digits">
                    </div>
                </div>
                <div class="row">
                    <div class="input-data">
                        <label for="password">Password<i class="fa-solid fa-key"></i></label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required pattern=".{8,}" title="Password must be at least 8 characters long">
                    </div>
                    <div class="input-data">
                        <label for="confirm">Confirm Password<i class="fa-solid fa-key"></i></label>
                        <input type="password" id="confirm-password" name="confirmpassword" placeholder="Confirm your password" required pattern=".{8,}" title="Password must be at least 8 characters long">
                    </div>
                </div>
                <div class="button">
                    <input type="submit" name="register" value="Register">
                    <span>Already have an account? Sign In <a href="login.php">Here</a>!</span>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Footer -->
    <footer>
        <p>&copy;2024 L's Hotel All Right Reserved.</p>
    </footer>
    
</body>
</html>
