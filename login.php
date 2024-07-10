<?php
session_start();

// Database connection settings
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "hotel"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailOrStaffId = $_POST['email-staffid'];
    $password = $_POST['password'];

    // Determine if it's an email or staff ID and prepare the SQL statement accordingly
    if (filter_var($emailOrStaffId, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT * FROM users WHERE email = ?";
    } else {
        $sql = "SELECT * FROM staff WHERE staffid = ?";
    }

    // Prepare and execute the SQL statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $emailOrStaffId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Check if the user exists and validate the password
        if ($user && (password_verify($password, $user['password']) || $user['password'] == $password)) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['fname'];
            $_SESSION['last_name'] = $user['lname'];
            if (isset($user['staffid'])) {
                header("Location: room.html");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            echo "Invalid login credentials.";
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

$conn->close();
?>
