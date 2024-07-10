<?php
// Database connection
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = mysqli_real_escape_string($conn, $_POST['fname']);
    $last_name = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows == 0) {
        // Insert new user
        $query = "INSERT INTO users (first_name, last_name, email, phone_number, password) VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$password')";

        if ($conn->query($query) === TRUE) {
            echo "<script>alert('Registration successful!'); window.location.href='login.html';</script>";
        } else {
            echo "<script>alert('Error: " . $query . "<br>" . $conn->error . "'); window.location.href='register.html';</script>";
        }
    } else {
        // Email already exists
        echo "<script>alert('Email already exists!'); window.location.href='register.html';</script>";
    }
}

$conn->close();
?>
