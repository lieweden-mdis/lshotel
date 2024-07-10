<?php
session_start();

// Database connection parameters
$servername = "localhost"; // Replace with your database server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "hotel"; // Replace with your database name

// Create connection
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input data from the form
    $email_staffid = $_POST['email-staffid'];
    $password = $_POST['password'];

    // Validate and sanitize inputs (you may need more validation as per your requirements)
    $email_staffid = htmlspecialchars($email_staffid);
    $password = htmlspecialchars($password);

    // Prepare SQL query to check login credentials in both user and staff tables
    $sql_user = "SELECT * FROM users WHERE email = :email AND password = :password";
    $sql_staff = "SELECT * FROM staff WHERE staff_id = :staff_id AND password = :password";

    // Prepare user query
    $stmt_user = $pdo->prepare($sql_user);
    $stmt_user->bindParam(':email', $email_staffid, PDO::PARAM_STR);
    $stmt_user->bindParam(':password', $password, PDO::PARAM_STR);

    // Prepare staff query
    $stmt_staff = $pdo->prepare($sql_staff);
    $stmt_staff->bindParam(':staff_id', $email_staffid, PDO::PARAM_STR); // Assuming staff_id is passed as email_staffid
    $stmt_staff->bindParam(':password', $password, PDO::PARAM_STR);

    // Execute user query
    $stmt_user->execute();
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    // Execute staff query
    $stmt_staff->execute();
    $staff = $stmt_staff->fetch(PDO::FETCH_ASSOC);

    // Check if either user or staff login is successful
    if ($user) {
        // User login successful
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        
        // Redirect to profile page or any other page after successful login
        header("Location: profile.php");
        exit();
    } elseif ($staff) {
        // Staff login successful
        $_SESSION['staff_id'] = $staff['staff_id']; // Assuming staff_id is stored in staff table
        $_SESSION['first_name'] = $staff['first_name']; // Adjust as per your staff table structure
        
        // Redirect to profile page or any other page after successful login
        header("Location: profile.php");
        exit();
    } else {
        // Login failed
        $error_message = "Invalid login credentials. Please try again.";
    }
}

// If login fails or form is not submitted, display login form with error message
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
    <header>
        <div>
            <img src="img/logo.png" alt="Logo">
        </div>
        <div class="user-links">
            <?php
            if (isset($error_message)) {
                echo '<p class="error">' . $error_message . '</p>';
            }

            // Check if first name and last name session variables are set
            if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
                // Concatenate first name and last name to form full name
                $full_name = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
                echo '<span>Welcome, ' . $full_name . '!</span>';
            } else {
                // Display default text or login/register links if not logged in
                echo '<a href="login.html">Login</a>';
                echo '<a href="register.html">Register</a>';
            }
            ?>
            <a href="profile.php"><img src="img/profile-icon.png" alt="profile-icon"></a>
        </div>
    </header>
    
    <nav>
        <a href="index.html">HOME</a>
        <a href="room.html">ROOM</a>
        <a href="facilities.html">FACILITIES</a>
        <a href="dining.html">DINING</a>
        <a href="about.html">ABOUT</a>
    </nav>

    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="login-form">
                <span class="form-header">User Login</span>
                <div class="row">
                    <div class="input-data">
                        <label for="email-staffid">Email / Staff ID</label>
                        <input type="text" id="email-staffid" name="email-staffid" placeholder="Enter your Email/ Staff ID" required>
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
                    <span>Do not have an account? Sign Up <a href="register.html">Here</a> !</span>
                </div>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy;2024 L's Hotel  All Right Reserved.</p>
    </footer>
</body>
</html>
