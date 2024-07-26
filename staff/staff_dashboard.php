<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../css/staff/staff-style.css?v=<?php echo time(); ?>">
    <title>L's HOTEL - STAFF DASHBOARD</title>
    <link rel="icon" href="../img/icon.jpg">

    <style>
        .container-shadow {
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            padding: 20px;
            border-radius: 10px;
            background-color: #ffffff;
            margin-top: 20px;
        }
        .room-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
        .room-box {
            padding: 15px; /* Reduced padding */
            border-radius: 0.8em;
            text-align: center;
            background-color: #f9f9f9;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 3px 8px; /* Softer shadow */
        }
        .room-box h3 {
            margin-top: 0;
            font-weight: bold;
            font-size: 2em; /* Further reduced font size */
            color: #4A90E2; /* Change color */
        }
        .room-box p {
            font-weight: bold;
            font-size: 2.5em; /* Further reduced font size */
            color: #333333; /* Darker color */
        }
        .section-title {
            text-align: left; /* Aligned to left */
            font-size: 2em;
            font-weight: bold;
            color: #333333;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="staff-container">
        <?php include 'staff_sidenav.php'; ?>
        <div class="main">
            <div class="staff-page-title">
                <span>Staff Dashboard</span>
            </div>
            <div class="container-shadow">
                <div class="section-title">Room Availability Overview</div>
                <div class="room-grid">
                    <?php
                    include '../config.php';

                    // Fetch room types and their availability directly from the database
                    $sql = "SELECT room_type, room_availability FROM rooms";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<div class='room-box'>";
                            echo "<h3>" . $row["room_type"] . "</h3>";
                            echo "<p>" . $row["room_availability"] . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<div class='room-box'><p>No data available</p></div>";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy;2024 L's Hotel All Right Reserved.</p>
    </footer>
</body>
</html>
