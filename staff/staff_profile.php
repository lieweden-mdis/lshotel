<?php
include 'staff_header.php';
include '../config.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user']['staff_id'])) {
    die("User is not logged in or session has expired.");
}

// Initialize variables with default values
$staff_id = $_SESSION['user']['staff_id'] ?? '';
$first_name = $_SESSION['user']['first_name'] ?? '';
$last_name = $_SESSION['user']['last_name'] ?? '';
$email = $_SESSION['user']['email'] ?? '';
$phone_number = $_SESSION['user']['phone_number'] ?? '';
$role = $_SESSION['user']['role'] ?? '';
$message = '';
$message_type = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the password fields are filled
    if (!empty($old_password) || !empty($new_password) || !empty($confirm_password)) {
        // Fetch the current password from the database
        $stmt = $conn->prepare("SELECT password FROM staff WHERE staff_id = ?");
        $stmt->bind_param('s', $staff_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($stored_password);
        $stmt->fetch();

        // Check if the old password matches the current password
        if ($stmt->num_rows == 0 || $old_password !== $stored_password) {
            $message = "Old password is incorrect!";
            $message_type = 'error';
        } elseif ($new_password !== $confirm_password) {
            $message = "New passwords do not match!";
            $message_type = 'error';
        } else {
            // Update the user's information and password if provided
            $stmt = $conn->prepare("UPDATE staff SET first_name = ?, last_name = ?, email = ?, phone_number = ?, password = ? WHERE staff_id = ?");
            $stmt->bind_param('ssssss', $first_name, $last_name, $email, $phone_number, $new_password, $staff_id);

            if ($stmt->execute()) {
                // Update the session variables
                $_SESSION['user']['first_name'] = $first_name;
                $_SESSION['user']['last_name'] = $last_name;
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['phone_number'] = $phone_number;
                $_SESSION['user']['password'] = $new_password; // Update password in session as well

                $message = "Profile updated successfully!";
                $message_type = 'success';
            } else {
                $message = "Failed to update profile.";
                $message_type = 'error';
            }
        }
        // Close statement
        $stmt->close();
    } else {
        // Update the user's information without changing the password
        $stmt = $conn->prepare("UPDATE staff SET first_name = ?, last_name = ?, email = ?, phone_number = ? WHERE staff_id = ?");
        $stmt->bind_param('sssss', $first_name, $last_name, $email, $phone_number, $staff_id);

        if ($stmt->execute()) {
            // Update the session variables
            $_SESSION['user']['first_name'] = $first_name;
            $_SESSION['user']['last_name'] = $last_name;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['phone_number'] = $phone_number;

            $message = "Profile updated successfully!";
            $message_type = 'success';
        } else {
            $message = "Failed to update profile.";
            $message_type = 'error';
        }
        // Close statement
        $stmt->close();
    }

    // Store message in session to be displayed after redirect
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $message_type;

    // Redirect to the same page to avoid form resubmission on refresh
    header("Location: staff_profile.php");
    exit;
}

// Retrieve message from session if exists
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];

    // Clear message from session
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="../css/staff/staff-style.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="../css/staff/staff_profile.css?v=<?php echo time(); ?>">
<title>L's HOTEL - STAFF PROFILE</title>
<link rel="icon" href="../img/icon.jpg">
</head>
<body>
<div class="staff-container">
  <?php include 'staff_sidenav.php'; ?>
  <div class="main">
    <div class="staff-page-title">
      <span>Staff Profile</span>
    </div>
    <div class="profile-container">
      <form id="profile-form" method="POST" action="" class="profile-form">
        <?php if ($message): ?>
        <div class="message <?php echo $message_type; ?>">
          <?php echo $message; ?>
        </div>
        <?php endif; ?>
        
        <div class="section-header">Personal Information</div>
        
        <div class="profile-item full">
          <label for="staff-id">Staff ID:</label>
          <input type="text" id="staff-id" name="staff_id" value="<?php echo htmlspecialchars($staff_id); ?>" readonly>
        </div>
        <div class="profile-item">
          <label for="first-name">First Name:</label>
          <input type="text" id="first-name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required readonly>
        </div>
        <div class="profile-item">
          <label for="last-name">Last Name:</label>
          <input type="text" id="last-name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required readonly>
        </div>
        <div class="profile-item">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required readonly>
        </div>
        <div class="profile-item">
          <label for="phone">Phone Number:</label>
          <input type="tel" id="phone" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" required readonly>
        </div>
        <div class="profile-item full">
          <label for="role">Role:</label>
          <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($role); ?>" readonly>
        </div>
        
        <div class="section-header">Password Management</div>
        
        <div class="profile-item full">
          <label for="old-password">Old Password:</label>
          <input type="password" id="old-password" name="old_password" placeholder="Enter old password" readonly>
        </div>
        <div class="profile-item">
          <label for="password">New Password:</label>
          <input type="password" id="password" name="password" placeholder="Enter new password" readonly>
        </div>
        <div class="profile-item">
          <label for="confirm-password">Confirm Password:</label>
          <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm new password" readonly>
        </div>
        <div class="btn-container">
          <button type="button" id="edit-button" class="btn"><i class="fa fa-pencil"></i> Edit</button>
          <button type="submit" id="update-button" class="btn btn-green" style="display:none;">Update</button>
          <button type="button" id="cancel-button" class="btn btn-gray" style="display:none;">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.getElementById('edit-button').addEventListener('click', function() {
    // Enable the form fields
    document.querySelectorAll('#profile-form input').forEach(input => {
        if (input.id !== 'staff-id' && input.id !== 'role') {
            input.removeAttribute('readonly');
        }
    });

    // Show the update and cancel buttons
    document.getElementById('update-button').style.display = 'inline-block';
    document.getElementById('cancel-button').style.display = 'inline-block';

    // Hide the edit button
    document.getElementById('edit-button').style.display = 'none';
});

document.getElementById('cancel-button').addEventListener('click', function() {
    // Reset the form fields to their original values
    document.querySelector('#first-name').value = '<?php echo $_SESSION['user']['first_name'] ?? ''; ?>';
    document.querySelector('#last-name').value = '<?php echo $_SESSION['user']['last_name'] ?? ''; ?>';
    document.querySelector('#email').value = '<?php echo $_SESSION['user']['email'] ?? ''; ?>';
    document.querySelector('#phone').value = '<?php echo $_SESSION['user']['phone_number'] ?? ''; ?>';
    document.querySelector('#old-password').value = '';
    document.querySelector('#password').value = '';
    document.querySelector('#confirm-password').value = '';

    // Disable the form fields
    document.querySelectorAll('#profile-form input').forEach(input => {
        input.setAttribute('readonly', 'readonly');
    });

    // Hide the update and cancel buttons
    document.getElementById('update-button').style.display = 'none';
    document.getElementById('cancel-button').style.display = 'none';

    // Show the edit button
    document.getElementById('edit-button').style.display = 'inline-block';
});

// Validate passwords before submitting the form
document.getElementById('profile-form').addEventListener('submit', function(event) {
    let password = document.getElementById('password').value;
    let confirmPassword = document.getElementById('confirm-password').value;

    if (password !== confirmPassword) {
        event.preventDefault();
        var messageBox = document.createElement('div');
        messageBox.className = 'message error';
        messageBox.textContent = "Passwords do not match!";
        var profileForm = document.getElementById('profile-form');
        profileForm.insertBefore(messageBox, profileForm.firstChild);
    }
});

// Hide the message after 5 seconds
if (document.querySelector('.message')) {
    setTimeout(function() {
        var messageBox = document.querySelector('.message');
        if (messageBox) {
            messageBox.style.display = 'none';
        }
    }, 2000);
}
</script>
<footer>
  <p>&copy;2024 L's Hotel All Right Reserved.</p>
</footer>
</body>
</html>
