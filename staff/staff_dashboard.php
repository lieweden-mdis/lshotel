<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../css/staff/staff-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/staff/staff-dashboard.css?v=<?php echo time(); ?>">
    <title>L's HOTEL - STAFF DASHBOARD</title>
    <link rel="icon" href="../img/icon.jpg">
</head>
<body>
    <?php
        $current_year = date('Y');
        $current_month = date('m');
        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];

        $filter_year = $_GET['year'] ?? $current_year;
        $filter_month = $_GET['month'] ?? $current_month;
        $filter_month_year = $months[$filter_month] . ' ' . $filter_year;

        // Ensure the month and year are treated as integers
        $filter_month = intval($filter_month);
        $filter_year = intval($filter_year);

        include '../config.php';
    ?>
    
    <div class="staff-container">
        <?php include 'staff_sidenav.php'; ?>
        <div class="main">
            <div class="staff-page-title">
                <span>Staff Dashboard</span>
            </div>

            <form class="filter-form" method="get">
                <select name="month">
                    <?php
                    foreach ($months as $key => $name) {
                        echo "<option value=\"$key\" " . ($key == $filter_month ? 'selected' : '') . ">$name</option>";
                    }
                    ?>
                </select>
                <select name="year">
                    <?php
                    for ($i = 2020; $i <= $current_year; $i++) {
                        echo "<option value=\"$i\" " . ($i == $filter_year ? 'selected' : '') . ">$i</option>";
                    }
                    ?>
                </select>
                <button type="submit">Filter</button>
            </form>

            <!-- Room Availability -->
            <div class="section">
                <div class="section-title">Room Availability</div>
                <div class="grid-container" id="room-availability-container">
                    <?php
                    // Fetch room availability from database
                    $query = "SELECT room_type, SUM(room_availability) as available FROM rooms GROUP BY room_type";
                    $result = $conn->query($query);
                    
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='card'>
                                <h3>{$row['room_type']}</h3>
                                <p>{$row['available']}</p>
                              </div>";
                    }
                    ?>
                </div>
            </div>

            <!-- Booking Overview -->
            <div class="section">
                <div class="section-title">Booking Overview - <?php echo $filter_month_year; ?></div>
                <div class="booking-overview-container">
                    <?php
                    // Initialize booking counts
                    $total_bookings = $completed_bookings = $pending_bookings = $cancelled_bookings = 0;

                    // Fetch all bookings and filter by check-in date
                    $all_bookings_query = "
                        SELECT booking_status, COUNT(*) as total 
                        FROM bookings 
                        WHERE MONTH(check_in_date) = $filter_month 
                        AND YEAR(check_in_date) = $filter_year
                        GROUP BY booking_status";
                    $all_bookings_result = $conn->query($all_bookings_query);

                    if ($all_bookings_result) {
                        while ($row = $all_bookings_result->fetch_assoc()) {
                            $status = $row['booking_status'];
                            $count = $row['total'];
                            if ($status == 'completed') {
                                $completed_bookings = $count;
                            } elseif ($status == 'pending') {
                                $pending_bookings = $count;
                            } elseif ($status == 'cancelled') {
                                $cancelled_bookings = $count;
                            }
                            $total_bookings += $count;
                        }
                    }
                    ?>

                    <div class="card booking-item">
                        <h3>Total Bookings</h3>
                        <p id="total-bookings"><?php echo $total_bookings; ?></p>
                    </div>
                    <div class="card booking-item">
                        <h3>Pending Bookings</h3>
                        <p id="pending-bookings"><?php echo $pending_bookings; ?></p>
                    </div>
                    <div class="card booking-item">
                        <h3>Completed Bookings</h3>
                        <p id="completed-bookings"><?php echo $completed_bookings; ?></p>
                    </div>
                    <div class="card booking-item">
                        <h3>Cancelled Bookings</h3>
                        <p id="cancelled-bookings"><?php echo $cancelled_bookings; ?></p>
                    </div>
                </div>
            </div>

            <!-- Revenue Overview -->
            <div class="section">
                <div class="section-title">Revenue Overview - <?php echo $filter_month_year; ?></div>
                <div class="revenue-overview-container">
                    <div class="revenue-left">
                        <div class="card revenue-item">
                            <?php
                            // Initialize revenue amounts
                            $total_revenue = $refunded_revenue = 0;

                            // Fetch total revenue data from database
                            $total_revenue_query = "
                                SELECT SUM(b.total_amount) as total 
                                FROM bookings b
                                JOIN rooms r ON b.room_id = r.room_id
                                WHERE b.payment_status = 'success' 
                                AND MONTH(b.check_in_date) = $filter_month
                                AND YEAR(b.check_in_date) = $filter_year";
                            $total_revenue_result = $conn->query($total_revenue_query);
                            if ($total_revenue_result && $total_row = $total_revenue_result->fetch_assoc()) {
                                $total_revenue = $total_row['total'] ?? 0;
                            }
                            ?>
                            <h3>Total Revenue</h3>
                            <p id="total-revenue">RM <?php echo number_format($total_revenue, 2); ?></p>
                        </div>
                        <div class="card revenue-item">
                            <?php
                            // Fetch refunded revenue data from database
                            $refunded_revenue_query = "
                                SELECT SUM(b.total_amount) as total 
                                FROM bookings b
                                JOIN rooms r ON b.room_id = r.room_id
                                WHERE b.payment_status = 'refunded' 
                                AND MONTH(b.check_in_date) = $filter_month
                                AND YEAR(b.check_in_date) = $filter_year";
                            $refunded_revenue_result = $conn->query($refunded_revenue_query);
                            if ($refunded_revenue_result && $refunded_row = $refunded_revenue_result->fetch_assoc()) {
                                $refunded_revenue = $refunded_row['total'] ?? 0;
                            }
                            ?>
                            <h3>Refunded Amount</h3>
                            <p id="refunded-revenue">RM <?php echo number_format($refunded_revenue, 2); ?></p>
                        </div>
                    </div>
                    <div class="revenue-right">
                        <?php
                        // Initialize room types
                        $room_types = ['Standard Room', 'Deluxe Room', 'Triple Room', 'Family Suite Room'];
                        // Initialize revenue data
                        $revenue_data = array_fill_keys($room_types, 0);

                        // Fetch revenue by room type data from database
                        $revenue_by_room_query = "
                            SELECT r.room_type, SUM(b.total_amount) as total 
                            FROM bookings b
                            JOIN rooms r ON b.room_id = r.room_id
                            WHERE b.payment_status = 'success' 
                            AND MONTH(b.check_in_date) = $filter_month
                            AND YEAR(b.check_in_date) = $filter_year
                            GROUP BY r.room_type";
                        $revenue_by_room_result = $conn->query($revenue_by_room_query);
                        
                        while ($row = $revenue_by_room_result->fetch_assoc()) {
                            $revenue_data[$row['room_type']] = $row['total'];
                        }

                        // Display revenue for each room type
                        foreach ($room_types as $room_type) {
                            $revenue = $revenue_data[$room_type] ?? 0;
                            echo "<div class='card revenue-item'>
                                    <h3>{$room_type} Revenue</h3>
                                    <p>RM ".number_format($revenue, 2)."</p>
                                  </div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <p>&copy;2024 L's Hotel All Right Reserved.</p>
    </footer>
    <script src="../script/staff-dashboard.js"></script>
</body>
</html>
