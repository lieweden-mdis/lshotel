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
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="staff-container">
  <?php include 'staff_sidenav.php'; ?>
  <div class="main">
    <div class="staff-page-title">
      <span>Staff User Management</span>
    </div>
    <!-- Content specific to this page -->
    <div class="container mt-5">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#staffModal" onclick="openAddModal()">Add Staff</button>
        <table class="table table-bordered">
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
                <?php
                $result = $conn->query("SELECT * FROM staff");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['staff_id']}</td>
                            <td>{$row['first_name']}</td>
                            <td>{$row['last_name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['phone_number']}</td>
                            <td>{$row['role']}</td>
                            <td>
                                <button class='btn btn-warning btn-sm' onclick='openEditModal(\"{$row['staff_id']}\", \"{$row['first_name']}\", \"{$row['last_name']}\", \"{$row['email']}\", \"{$row['phone_number']}\", \"{$row['role']}\")'>Edit</button>
                                <button class='btn btn-danger btn-sm' onclick='deleteStaff(\"{$row['staff_id']}\")'>Delete</button>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="staffModal" tabindex="-1" role="dialog" aria-labelledby="staffModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staffModalLabel">Add/Edit Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="staffForm" method="POST" action="staff_management.php" onsubmit="return validateForm()">
                        <div class="form-group">
                            <label for="staffId">Staff ID</label>
                            <input type="text" class="form-control" id="staffId" name="staff_id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="text" class="form-control" id="phoneNumber" name="phone_number" required pattern="\d+">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </div>
                        <div class="form-group" id="passwordFields">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <label for="confirmPassword">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <form id="deleteForm" method="POST" action="staff_management.php" style="display: none;">
        <input type="hidden" name="delete_staff_id" id="deleteStaffId">
    </form>
  </div>
</div>
<footer>
  <p>&copy;2024 L's Hotel All Right Reserved.</p>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function openAddModal() {
        document.getElementById('staffModalLabel').innerText = 'Add Staff';
        document.getElementById('staffForm').reset();
        document.getElementById('passwordFields').style.display = 'block';
        document.getElementById('staffId').readOnly = false;
        document.getElementById('staffId').value = '';
        $('#staffModal').modal('show');
    }

    function openEditModal(id, firstName, lastName, email, phoneNumber, role) {
        document.getElementById('staffModalLabel').innerText = 'Edit Staff';
        document.getElementById('staffId').value = id;
        document.getElementById('firstName').value = firstName;
        document.getElementById('lastName').value = lastName;
        document.getElementById('email').value = email;
        document.getElementById('phoneNumber').value = phoneNumber;
        document.getElementById('role').value = role;
        document.getElementById('passwordFields').style.display = 'none';
        document.getElementById('staffId').readOnly = true;
        $('#staffModal').modal('show');
    }

    function deleteStaff(id) {
        if (confirm('Are you sure you want to delete this staff member?')) {
            document.getElementById('deleteStaffId').value = id;
            document.getElementById('deleteForm').submit();
        }
    }

    function validateForm() {
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const email = document.getElementById('email').value;
        const phoneNumber = document.getElementById('phoneNumber').value;
        const role = document.getElementById('role').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (!firstName || !lastName || !email || !phoneNumber || !role) {
            alert('All fields are required.');
            return false;
        }

        if (password !== confirmPassword) {
            alert('Passwords do not match.');
            return false;
        }

        const phonePattern = /^\d+$/;
        if (!phonePattern.test(phoneNumber)) {
            alert('Phone number must be digits only.');
            return false;
        }

        return true;
    }
</script>
</body>
</html>
