<?php
include '../config.php'; // Include your database connection file

$room_type = $_GET['room_type'];

// Fetch bed selection options
$bedSelectionQuery = "SELECT feature_value FROM room_features WHERE feature_name = 'bed_selection' AND room_type = '$room_type'";
$bedSelectionResult = $conn->query($bedSelectionQuery);
$bedSelectionOptions = [];
if ($bedSelectionResult->num_rows > 0) {
    while($row = $bedSelectionResult->fetch_assoc()) {
        $bedSelectionOptions[] = $row['feature_value'];
    }
}

// Fetch smoke options
$smokeQuery = "SELECT feature_value FROM room_features WHERE feature_name = 'smoke' AND room_type = '$room_type'";
$smokeResult = $conn->query($smokeQuery);
$smokeOptions = [];
if ($smokeResult->num_rows > 0) {
    while($row = $smokeResult->fetch_assoc()) {
        $smokeOptions[] = $row['feature_value'];
    }
}

$conn->close();

// Return as JSON
echo json_encode(['bed_selection' => $bedSelectionOptions, 'smoke' => $smokeOptions]);
?>
