
<?php

include 'staff_header.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../config.php'; // Ensure this path is correct

function getPendingBookingCount($conn) {
    $sql = "SELECT COUNT(*) as count FROM bookings WHERE booking_status = 'pending'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else {
        return 0;
    }
}

if (isset($conn)) {
    $pendingCount = getPendingBookingCount($conn);
} else {
    $pendingCount = 0;
}

$staffName = isset($_SESSION['user_full_name']) ? $_SESSION['user_full_name'] : 'Unknown User';
$staffId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 'N/A';
$staffRole = isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : 'N/A';
?>
<div class="sidenav">
    <div class="logo">
        <img src="../img/logo.png" alt="logo" />
    </div>
    <div class="staff-info">
        <span id="staff-name"><i class="fa fa-user"></i> <?php echo $staffName; ?></span>
        <span id="staff-id"><i class="fa fa-id-badge"></i> <?php echo $staffId; ?></span>
        <div class="role-logout-container">
            <span id="role" class="role"><i class="fa fa-briefcase"></i> <?php echo $staffRole; ?></span>
            <a href="../logout.php" class="logout"><i class="fa fa-sign-out"></i> Logout</a>
        </div>
    </div>
    <hr/>
    <a href="staff_dashboard.php" class="category" target="_self">
        <i class="fa fa-dashboard"></i> Staff Dashboard
    </a>
    
    <div class="category dropdown-btn active">
        <i class="fa fa-building"></i> Room Management <i class="fa fa-caret-down"></i>
    </div>
    <div class="dropdown-container" style="max-height: 500px; padding-top: 0.5em; padding-bottom: 0.5em;">
        <a href="room_info.php" target="_self"><i class="fa fa-info-circle"></i> Room Info</a>
    </div>

    <div class="category dropdown-btn active">
        <i class="fa fa-book"></i> Booking Management <i class="fa fa-caret-down"></i>
    </div>
    <div class="dropdown-container" style="max-height: 500px; padding-top: 0.5em; padding-bottom: 0.5em;">
        <a href="all_booking.php" target="_self"><i class="fa fa-list"></i> All Booking</a>
        <a href="pending_booking.php" target="_self" id="pending-booking-link"><i class="fa fa-clock-o"></i> Pending Booking <span class="notification"><?php echo $pendingCount; ?></span></a>
    </div>

    <div class="category dropdown-btn active">
        <i class="fa fa-users"></i> User Management <i class="fa fa-caret-down"></i>
    </div>
    <div class="dropdown-container" style="max-height: 500px; padding-top: 0.5em; padding-bottom: 0.5em;">
        <a href="staff_profile.php" target="_self"><i class="fa fa-user"></i> Staff Profile</a>
        <?php if ($staffRole === 'Admin'): ?>
            <a href="staff_management.php" target="_self"><i class="fa fa-cogs"></i> Staff User Management</a>
        <?php endif; ?>
    </div>
</div>

<script>
    var dropdown = document.getElementsByClassName("dropdown-btn");
    for (let i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.maxHeight) {
                dropdownContent.style.maxHeight = null;
                dropdownContent.style.paddingTop = "0";
                dropdownContent.style.paddingBottom = "0";
            } else {
                dropdownContent.style.maxHeight = dropdownContent.scrollHeight + "px";
                dropdownContent.style.paddingTop = "0.5em";
                dropdownContent.style.paddingBottom = "0.5em";
            }
        });
    }
</script>
