<?php
session_start();
include '../config.php';

$message = NULL;
$messageType = NULL; // 'success' or 'error'

// Function to check if an email or phone number exists in both staff and user tables
function isEmailOrPhoneDuplicate($conn, $email, $phoneNumber, $staffId = null) {
    // Check in staff table
    $query = "SELECT * FROM staff WHERE (email = ? OR phone_number = ?)";
    $params = [$email, $phoneNumber];
    $types = "ss";

    if ($staffId) {
        $query .= " AND staff_id != ?";
        $params[] = $staffId;
        $types .= "s";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $staffResult = $stmt->get_result();
    $stmt->close();

    // Check in user table
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR phone_number = ?");
    $stmt->bind_param("ss", $email, $phoneNumber);
    $stmt->execute();
    $userResult = $stmt->get_result();
    $stmt->close();

    return ($staffResult->num_rows > 0 || $userResult->num_rows > 0);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == 'add') {
            // Add new staff
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $phoneNumber = $_POST['phone_number'];
            $role = $_POST['role'];
            $password = $_POST['password'];

            // Check if email or phone number already exists in staff or user table
            if (isEmailOrPhoneDuplicate($conn, $email, $phoneNumber)) {
                $_SESSION['error_message'] = "Email or phone number already exists. Please use a different email or phone number.";
            } else {
                // Email and phone number do not exist, proceed with insertion
                $stmt = $conn->prepare("INSERT INTO staff (first_name, last_name, email, phone_number, role, password) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $firstName, $lastName, $email, $phoneNumber, $role, $password);
                $stmt->execute();

                // Get the auto-increment ID
                $lastId = $stmt->insert_id;

                // Generate Staff ID based on role
                $staffIdPrefix = ($role === 'Admin') ? 'A' : 'S';
                $staffId = sprintf('%s%05d', $staffIdPrefix, $lastId);

                // Update the staff record with the generated Staff ID
                $updateStmt = $conn->prepare("UPDATE staff SET staff_id = ? WHERE id = ?");
                $updateStmt->bind_param("si", $staffId, $lastId);
                $updateStmt->execute();
                $updateStmt->close();

                $stmt->close();

                $_SESSION['success_message'] = "Staff successfully added.";
            }

        } elseif ($action == 'edit') {
            // Edit existing staff
            $staffId = $_POST['staff_id'];
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $phoneNumber = $_POST['phone_number'];
            $role = $_POST['role'];

            // Check if email or phone number already exists in staff or user table for another user
            if (isEmailOrPhoneDuplicate($conn, $email, $phoneNumber, $staffId)) {
                $_SESSION['error_message'] = "Email or phone number already exists for another user. Please use a different email or phone number.";
            } else {
                // Email and phone number do not exist for another user, proceed with update
                $stmt = $conn->prepare("UPDATE staff SET first_name = ?, last_name = ?, email = ?, phone_number = ?, role = ? WHERE staff_id = ?");
                $stmt->bind_param("ssssss", $firstName, $lastName, $email, $phoneNumber, $role, $staffId);
                $stmt->execute();
                $stmt->close();

                $_SESSION['success_message'] = "Profile successfully updated.";
            }
        } elseif ($action == 'delete') {
            // Verify admin credentials
            $adminIdEmail = $_POST['admin_id_email'];
            $adminPassword = $_POST['admin_password'];

            // Check admin credentials using Staff ID or Email
            $stmt = $conn->prepare("SELECT * FROM staff WHERE (staff_id = ? OR email = ?) AND password = ? AND role = 'Admin'");
            $stmt->bind_param("sss", $adminIdEmail, $adminIdEmail, $adminPassword);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Admin credentials are correct, proceed with deletion
                $staffId = $_POST['delete_staff_id'];
                $stmt = $conn->prepare("DELETE FROM staff WHERE staff_id = ?");
                $stmt->bind_param("s", $staffId);
                $stmt->execute();
                $stmt->close();

                $_SESSION['success_message'] = "User successfully deleted.";
            } else {
                $_SESSION['error_message'] = "Invalid admin credentials.";
            }
        }
    }

    // Redirect to avoid form resubmission issues
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

$result = $conn->query("SELECT * FROM staff");

$loggedInStaffId = isset($_SESSION['logged_in_staff_id']) ? $_SESSION['logged_in_staff_id'] : null;
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="../css/staff/staff-style.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="../css/staff/staff-management.css?v=<?php echo time(); ?>">
<title>L's HOTEL - Staff User Management</title>
<link rel="icon" href="../img/icon.jpg">

</head>
<body>
<div class="staff-container">
  <?php include 'staff_sidenav.php'; ?>
  <div class="main">
    <div class="staff-page-title">
      <span>Staff User Management</span>
    </div>
    <!-- Content specific to this page -->
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <button class="btn btn-primary" id="addStaffButton">Add Staff</button>
            <?php if (isset($_SESSION['success_message'])) : ?>
                <div class="message success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error_message'])) : ?>
                <div class="message error"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
            <?php endif; ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="staffTableBody">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['staff_id']; ?></td>
                        <td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone_number']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                            <div class="actions">
                                <button class="btn btn-warning btn-sm editButton" data-id="<?php echo $row['staff_id']; ?>" data-firstname="<?php echo $row['first_name']; ?>" data-lastname="<?php echo $row['last_name']; ?>" data-email="<?php echo $row['email']; ?>" data-phonenumber="<?php echo $row['phone_number']; ?>" data-role="<?php echo $row['role']; ?>">Edit</button>
                                <button class="btn btn-danger btn-sm deleteButton <?php echo $row['staff_id'] === $loggedInStaffId ? 'btn-disabled' : NULL; ?>" data-id="<?php echo $row['staff_id']; ?>" <?php echo $row['staff_id'] === $loggedInStaffId ? 'disabled' : NULL; ?>>Delete</button>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Modal -->
    <div id="addStaffModal" class="modal">
        <div class="modal-content">
            <span class="close" id="addModalClose">&times;</span>
            <h5 class="modal-title" id="addStaffModalLabel">Add Staff</h5>
            <div id="addModalMessage" class="message error" style="display: none;"></div>
            <form id="addStaffForm" method="POST" action="" onsubmit="return validateAddForm()">
                <input type="hidden" id="formActionAdd" name="action" value="add">
                <div class="form-group">
                    <label for="addFirstName">First Name</label>
                    <input type="text" class="form-control" id="addFirstName" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="addLastName">Last Name</label>
                    <input type="text" class="form-control" id="addLastName" name="last_name" required>
                </div>
                <div class="form-group">
                    <label for="addEmail">Email</label>
                    <input type="email" class="form-control" id="addEmail" name="email" required>
                </div>
                <div class="form-group">
                    <label for="addPhoneNumber">Phone Number</label>
                    <input type="text" class="form-control" id="addPhoneNumber" name="phone_number" required pattern="\d{8,11}">
                </div>
                <div class="form-group">
                    <label for="addRole">Role</label>
                    <select class="form-control" id="addRole" name="role" required>
                        <option value="">Select Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Staff">Staff</option>
                    </select>
                </div>
                <div class="form-group" id="addPasswordFields">
                    <label for="addPassword">Password</label>
                    <input type="password" class="form-control" id="addPassword" name="password" required>
                    <label for="addConfirmPassword">Confirm Password</label>
                    <input type="password" class="form-control" id="addConfirmPassword" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editStaffModal" class="modal">
        <div class="modal-content">
            <span class="close" id="editModalClose">&times;</span>
            <h5 class="modal-title" id="editStaffModalLabel">Edit Staff</h5>
            <div id="editModalMessage" class="message error" style="display: none;"></div>
            <form id="editStaffForm" method="POST" action="" onsubmit="return validateEditForm()">
                <input type="hidden" id="formActionEdit" name="action" value="edit">
                <div class="form-group" id="editStaffIdField">
                    <label for="editStaffId">Staff ID</label>
                    <input type="text" class="form-control" id="editStaffId" name="staff_id" readonly>
                </div>
                <div class="form-group">
                    <label for="editFirstName">First Name</label>
                    <input type="text" class="form-control" id="editFirstName" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="editLastName">Last Name</label>
                    <input type="text" class="form-control" id="editLastName" name="last_name" required>
                </div>
                <div class="form-group">
                    <label for="editEmail">Email</label>
                    <input type="email" class="form-control" id="editEmail" name="email" required>
                </div>
                <div class="form-group">
                    <label for="editPhoneNumber">Phone Number</label>
                    <input type="text" class="form-control" id="editPhoneNumber" name="phone_number" required pattern="\d{8,11}">
                </div>
                <div class="form-group">
                    <label for="editRole">Role</label>
                    <select class="form-control" id="editRole" name="role" required>
                        <option value="Admin">Admin</option>
                        <option value="Staff">Staff</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteStaffModal" class="modal">
        <div class="modal-content">
            <span class="close" id="deleteModalClose">&times;</span>
            <h5 class="modal-title" id="deleteStaffModalLabel">Delete Staff</h5>
            <div id="deleteModalMessage" class="message error" style="display: none;"></div>
            <form id="deleteStaffForm" method="POST" action="">
                <input type="hidden" name="delete_staff_id" id="deleteStaffId">
                <input type="hidden" name="action" value="delete">
                <div class="form-group">
                    <label for="adminIdEmail">Admin Staff ID/Email</label>
                    <input type="text" class="form-control" id="adminIdEmail" name="admin_id_email" required>
                </div>
                <div class="form-group">
                    <label for="adminPassword">Admin Password</label>
                    <input type="password" class="form-control" id="adminPassword" name="admin_password" required>
                </div>
                <button type="submit" class="btn btn-danger">Confirm Delete</button>
            </form>
        </div>
    </div>
  </div>
</div>
<footer>
  <p>&copy;2024 L's Hotel All Right Reserved.</p>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    var loggedInStaffId = '<?php echo $loggedInStaffId; ?>';

    $(document).ready(function() {
        $('#addStaffButton').on('click', function() {
            console.log('openAddModal called');
            $('#addStaffModalLabel').text('Add Staff');
            $('#addStaffForm')[0].reset();
            $('#addPassword').attr('required', true);
            $('#addConfirmPassword').attr('required', true);
            $('#addPasswordFields').show();
            $('#formActionAdd').val('add');
            $('#addStaffModal').show();
            $('#addModalMessage').hide();
        });

        $('.editButton').on('click', function() {
            console.log('openEditModal called');
            const staffId = $(this).data('id');
            const firstName = $(this).data('firstname');
            const lastName = $(this).data('lastname');
            const email = $(this).data('email');
            const phoneNumber = $(this).data('phonenumber');
            const role = $(this).data('role');

            $('#editStaffModalLabel').text('Edit Staff');
            $('#editStaffId').val(staffId);
            $('#editFirstName').val(firstName);
            $('#editLastName').val(lastName);
            $('#editEmail').val(email);
            $('#editPhoneNumber').val(phoneNumber);
            $('#editRole').val(role);

            $('#formActionEdit').val('edit');
            $('#editStaffModal').show();
            $('#editModalMessage').hide();
        });

        $('.deleteButton').each(function() {
            if ($(this).data('id') === loggedInStaffId) {
                $(this).prop('disabled', true); // Disable the delete button if it matches the logged-in user's ID
                $(this).addClass('btn-disabled'); // Add the class to change appearance
            }
        });

        $('.deleteButton').on('click', function() {
            console.log('openDeleteModal called');
            const staffId = $(this).data('id');
            $('#deleteStaffId').val(staffId);
            $('#deleteStaffModal').show();
            $('#deleteModalMessage').hide();
        });

        $('#addModalClose').on('click', function() {
            $('#addStaffModal').hide();
        });

        $('#editModalClose').on('click', function() {
            $('#editStaffModal').hide();
        });

        $('#deleteModalClose').on('click', function() {
            $('#deleteStaffModal').hide();
        });

        $(window).on('click', function(event) {
            if ($(event.target).is('#addStaffModal')) {
                $('#addStaffModal').hide();
            }
            if ($(event.target).is('#editStaffModal')) {
                $('#editStaffModal').hide();
            }
            if ($(event.target).is('#deleteStaffModal')) {
                $('#deleteStaffModal').hide();
            }
        });

        // Automatic disappearance of messages
        setTimeout(function() {
            $('.message').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 2000); // 2000 milliseconds = 2 seconds
    });

    function validateAddForm() {
        const firstName = $('#addFirstName').val();
        const lastName = $('#addLastName').val();
        const email = $('#addEmail').val();
        const phoneNumber = $('#addPhoneNumber').val();
        const role = $('#addRole').val();
        const password = $('#addPassword').val();
        const confirmPassword = $('#addConfirmPassword').val();

        console.log('First Name:', firstName);
        console.log('Last Name:', lastName);
        console.log('Email:', email);
        console.log('Phone Number:', phoneNumber);
        console.log('Role:', role);
        console.log('Password:', password);
        console.log('Confirm Password:', confirmPassword);

        if (!firstName || !lastName || !email || !phoneNumber || !role) {
            $('#addModalMessage').text('All fields are required.').show();
            return false;
        }

        if (!password || !confirmPassword) {
            $('#addModalMessage').text('Password fields are required for adding a new staff.').show();
            return false;
        }

        if (password !== confirmPassword) {
            $('#addModalMessage').text('Passwords do not match.').show();
            return false;
        }

        const phonePattern = /^\d{8,11}$/;
        if (!phonePattern.test(phoneNumber)) {
            $('#addModalMessage').text('Phone number must be an integer between 8 and 11 digits.').show();
            return false;
        }

        return true;
    }

    function validateEditForm() {
        const firstName = $('#editFirstName').val();
        const lastName = $('#editLastName').val();
        const email = $('#editEmail').val();
        const phoneNumber = $('#editPhoneNumber').val();
        const role = $('#editRole').val();

        console.log('First Name:', firstName);
        console.log('Last Name:', lastName);
        console.log('Email:', email);
        console.log('Phone Number:', phoneNumber);
        console.log('Role:', role);

        if (!firstName || !lastName || !email || !phoneNumber || !role) {
            $('#editModalMessage').text('All fields are required.').show();
            return false;
        }

        const phonePattern = /^\d{8,11}$/;
        if (!phonePattern.test(phoneNumber)) {
            $('#editModalMessage').text('Phone number only accept number between 8 and 11 digits.').show();
            return false;
        }

        return true;
    }
</script>
</body>
</html>