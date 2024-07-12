<?php
require 'header.php';
require 'config.php'; // Assuming you have a config.php for database connection

$error = ""; // Initialize error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted form data
    $emailStaffId = $_POST['email-staffid'];
    $password = $_POST['password'];

    // Basic validation
    if (empty($emailStaffId) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        // Database connection
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if it's a staff login (using staff ID or email)
        $stmt = $conn->prepare("SELECT id, password, first_name, last_name FROM staff WHERE (staff_id = ? OR email = ?)");
        $stmt->bind_param("ss", $emailStaffId, $emailStaffId);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Staff found, verify plain text password
            $stmt->bind_result($id, $plainPassword, $firstName, $lastName);
            $stmt->fetch();

            if ($password !== $plainPassword) {
                $error = "Login Unsuccessful, Staff ID/Email or Password error.";
            }
            $userType = 'staff';
        } else {
            // No staff found, check users table (assuming hashed passwords)
            $stmt->close();
            $stmt = $conn->prepare("SELECT id, password, first_name, last_name FROM users WHERE email = ?");
            $stmt->bind_param("s", $emailStaffId);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // User found, verify hashed password
                $stmt->bind_result($id, $hashedPassword, $firstName, $lastName);
                $stmt->fetch();

                if (!password_verify($password, $hashedPassword)) {
                    $error = "Login Unsuccessful, Email or Password error.";
                }
                $userType = 'user';
            } else {
                // No user found in users table
                $error = "Login Unsuccessful, Email or Password error.";
            }
        }

        // Start session if login is successful
        if (empty($error)) {
            session_start();
            $_SESSION['user_id'] = $id;
            $_SESSION['user_full_name'] = $lastName . " " . $firstName;
            
            // Redirect based on the type of user
            if ($userType === 'staff') {
                $_SESSION['user_type'] = 'staff';
                header("Location: staff-dashboard.php"); // Redirect to staff dashboard
            } else {
                $_SESSION['user_type'] = 'user';
                header("Location: index.php"); // Redirect to user home page
            }
            exit;
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
    <link rel="stylesheet" type="text/css" href="css/login.css">
    
    <title>L's HOTEL - LOGIN</title>
    <link rel="icon" href="img/icon.jpg">
</head>
<body>
    <div class="container">
        <!--Login Form-->
        <form action="login.php" method="POST">
            <div class="login-form">
                <span class="form-header">User Login</span>
                <?php
                    if (!empty($error)) {
                        echo '<span class="error" style="color: red;">' . $error . '</span>';
                    }
                ?>
                <div class="row">
                    <div class="input-data">
                        <label for="email-staffid">Email/Staff ID</label>
                        <input type="text" id="email-staffid" name="email-staffid" placeholder="Enter your Email or Staff ID" required>
                    </div>
                </div>
                <div class="row">
                    <div class="input-data">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your Password" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Login">
                    <span>Don't have an account? Sign Up <a href="register.php">Here</a>!</span>
                </div>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 L's Hotel All Rights Reserved.</p>
    </footer>
</body>
</html>
