<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

// Fetch user profile based on email
if (isset($_GET['action']) && $_GET['action'] == 'fetch_profile') {
    $email = $_SESSION['user']['email'];
    $sql = "SELECT first_name, last_name, email, phone_number, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user) {
        $user['password'] = str_repeat('*', 8); // Mask password with fixed 8 asterisks
        echo json_encode($user);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
    exit();
}

// Update user profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $current_email = $_SESSION['user']['email'];

    // Check for duplicates in users and staff tables
    $check_sql = "SELECT id FROM users WHERE (email = ? OR phone_number = ?) AND email != ?
                  UNION SELECT id FROM staff WHERE (email = ? OR phone_number = ?)";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("sssss", $email, $phone, $current_email, $email, $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email or phone number already exists', 'duplicateField' => $result->fetch_assoc()['id'] ? 'email' : 'phone']);
    } else {
        if (!empty($password)) {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $update_sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, phone_number = ?, password = ? WHERE email = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone, $password, $current_email);
        } else {
            $update_sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, phone_number = ? WHERE email = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $current_email);
        }

        if ($stmt->execute()) {
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['first_name'] = $first_name;
            $_SESSION['user']['last_name'] = $last_name;
            echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error updating profile']);
        }
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/profile.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="profile-page">
        <div class="sidebar">
            <a href="profile.php">Profile</a>
            <a href="reservation.php">Reservation</a>
        </div>
        <div class="content">
            <div class="profile-container-wrapper">
                <h2>My Profile</h2>
                <div id="message" class="message"></div>
                <div class="profile-container">
                    <div class="profile-field">
                        <label for="firstName">First Name:</label>
                        <input type="text" id="firstName" disabled>
                        <button class="edit-btn" onclick="editField('firstName')">Edit</button>
                    </div>
                    <div class="profile-field">
                        <label for="lastName">Last Name:</label>
                        <input type="text" id="lastName" disabled>
                        <button class="edit-btn" onclick="editField('lastName')">Edit</button>
                    </div>
                    <div class="profile-field">
                        <label for="email">Email:</label>
                        <input type="email" id="email" disabled>
                        <button class="edit-btn" onclick="editField('email')">Edit</button>
                    </div>
                    <div class="profile-field">
                        <label for="phone">Phone Number:</label>
                        <input type="text" id="phone" pattern="\d{8,11}" maxlength="11" disabled>
                        <button class="edit-btn" onclick="editField('phone')">Edit</button>
                    </div>
                    <div class="profile-field">
                        <label for="password">Password:</label>
                        <input type="password" id="password" value="********" disabled>
                        <button class="edit-btn" onclick="editField('password')">Edit</button>
                    </div>
                    <button class="save-btn">Save</button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy;2024 L's Hotel All Right Reserved.</p>
    </footer>
    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchProfile();

            document.querySelector('.save-btn').addEventListener('click', function(event) {
                event.preventDefault();
                if (validateForm()) {
                    saveProfile();
                }
            });
        });

        function fetchProfile() {
            fetch('?action=fetch_profile')
                .then(response => response.json())
                .then(data => {
                    if (data.status !== 'error') {
                        document.getElementById('firstName').value = data.first_name;
                        document.getElementById('lastName').value = data.last_name;
                        document.getElementById('email').value = data.email;
                        document.getElementById('phone').value = data.phone_number;
                        document.getElementById('password').value = data.password;
                    } else {
                        showMessage(data.message, 'error');
                    }
                })
                .catch(error => console.error('Error fetching profile:', error));
        }

        function editField(fieldId) {
            document.getElementById(fieldId).disabled = false;
            if (fieldId === 'password') {
                document.getElementById(fieldId).value = NULL;
            }
        }

        function validateForm() {
            let isValid = true;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phonePattern = /^\d{8,11}$/;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;

            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                isValid = false;
            }

            if (!phonePattern.test(phone)) {
                alert("Please enter a valid phone number with 8 to 11 digits.");
                isValid = false;
            }

            return isValid;
        }

        function saveProfile() {
            const data = {
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                password: document.getElementById('password').value
            };

            fetch(NULL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams(data)
            })
            .then(response => response.json())
            .then(result => {
                const messageDiv = document.getElementById('message');
                messageDiv.style.display = 'block';
                if (result.status === 'success') {
                    showMessage(result.message, 'success');
                    updateUserSession(data.firstName, data.lastName); // Update session user name
                } else {
                    showMessage(result.message, 'error');
                    // Clear the input fields if there is a duplicate error
                    if (result.message === 'Email or phone number already exists') {
                        if (result.duplicateField === 'email') {
                            document.getElementById('email').value = NULL;
                        } else if (result.duplicateField === 'phone') {
                            document.getElementById('phone').value = NULL;
                        }
                    }
                }
                fetchProfile(); // Refresh profile data
            })
            .catch(error => console.error('Error updating profile:', error));
        }

        function showMessage(message, type) {
            const messageDiv = document.getElementById('message');
            messageDiv.style.display = 'block';
            messageDiv.className = `message ${type}`;
            messageDiv.innerText = message;

            // Hide the message after 2 seconds
            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 3000);
        }

        function updateUserSession(firstName, lastName) {
            // Update the session user name displayed
            document.querySelector('.username-link').innerText = `${firstName} ${lastName}`;
        }
    </script>
</body>
</html>
