<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate input and check for duplicate email
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim($_POST['fname']);
    $lastName = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmpassword']);
    
    // Check if all fields are filled
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword)) {
        echo "All fields are required.";
        exit;
    }
    
    // Check if password and confirm password match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }
    
    // Check if email already exists
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "Email already exists.";
        exit;
    }
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
    // Insert the user into the database
    $sql = "INSERT INTO users (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $phone, $hashedPassword);
    
    if ($stmt->execute()) {
        echo "Registration successful.";
        // Redirect to the login page
        header("Location: login.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>
