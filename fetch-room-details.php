<?php
include 'config.php'; // Include the database configuration file

// Get the room type and response type from the POST request
$room_type = $_POST['room_type'];
$response_type = $_POST['response_type'] ?? 'html'; // Default to 'html' if not provided

// Fetch room details from the database
$sql = "SELECT * FROM rooms WHERE room_type = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $room_type);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $price = $row['room_price'];
    $features = explode(',', $row['room_features']);
    $facilities = explode(',', $row['room_facilities']);
    $size = $row['room_size'];
    $availability = $row['room_availability'];
    $description = $row['room_description'];
    $images = explode(',', $row['room_images']);

    // Filter bed and smoke options
    $bed_options = [];
    $smoking_options = [];
    foreach ($features as $feature) {
        $feature = trim($feature); // Remove leading/trailing whitespace
        if (strpos(strtolower($feature), 'bed') !== false) {
            $bed_options[] = $feature;
        } elseif (in_array(strtolower($feature), ['smoking', 'non-smoking'])) {
            $smoking_options[] = $feature;
        }
    }

    if ($response_type == 'html') {
        // Generate the HTML content dynamically for the room details page
        echo '<div class="roomcontainer">';
        echo '<div class="room-gallery">';
        foreach ($images as $index => $image) {
            echo '<div class="mySlides">';
            echo '<img src="img/room-image/' . strtolower(str_replace(' ', '-', $room_type)) . '/' . htmlspecialchars($image) . '" alt="roomimg' . ($index + 1) . '" style="width:100%">';
            echo '</div>';
        }

        echo '<a class="prev" onclick="plusSlides(-1)">❮</a>';
        echo '<a class="next" onclick="plusSlides(1)">❯</a>';

        echo '<div class="row">';
        foreach ($images as $index => $image) {
            echo '<div class="column">';
            echo '<img class="demo" src="img/room-image/' . strtolower(str_replace(' ', '-', $room_type)) . '/' . htmlspecialchars($image) . '" style="width:100%" onclick="currentSlide(' . ($index + 1) . ')" alt="image' . ($index + 1) . '">';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';

        echo '<div class="room-details">';
        echo '<span class="price">RM' . htmlspecialchars($price) . ' per night</span>';
        echo '<div class="features">';
        echo '<span class="label">Features</span>';
        echo '<div class="features-list">';
        foreach ($features as $feature) {
            echo '<span class="features-items">' . htmlspecialchars($feature) . '</span>';
        }
        echo '</div>';
        echo '</div>';
        echo '<div class="facility">';
        echo '<span class="label">Facilities</span>';
        echo '<div class="facility-list">';
        foreach ($facilities as $facility) {
            echo '<span class="facility-items">' . htmlspecialchars($facility) . '</span>';
        }
        echo '</div>';
        echo '</div>';

        echo '<div class="size">';
        echo '<span class="label">Size</span>';
        echo '<span class="size-info">' . htmlspecialchars($size) . '</span>';
        echo '</div>';

        echo '<button id="bookNow" class="book-now-btn">Book Now</button>';
        echo '<div class="availability">';
        echo '<span>Room Availability: ' . htmlspecialchars($availability) . '</span>';
        echo '</div>';
        echo '<input type="hidden" id="roomAvailability" value="' . htmlspecialchars($availability) . '">';
        echo '</div>';
        echo '</div>';

        echo '<div class="room-description">';
        echo '<span class="description-header">Description</span>';
        echo '<p class="description-content">' . htmlspecialchars($description) . '</p>';
        echo '</div>';
    } else if ($response_type == 'json') {
        // Generate the JSON response for the booking page
        $roomDetails = [
            'name' => $room_type,
            'image' => 'img/room-image/' . strtolower(str_replace(' ', '-', $room_type)) . '/' . htmlspecialchars($images[0]), // Assuming the first image is used
            'price' => $price,
            'features' => $features,
            'size' => $size,
            'availability' => $availability,
            'description' => $description,
            'bed_options' => $bed_options,
            'smoking_options' => $smoking_options
        ];
        echo json_encode($roomDetails);
    }
} else {
    if ($response_type == 'html') {
        echo "No details found for the selected room type.";
    } else if ($response_type == 'json') {
        echo json_encode([]);
    }
}

$stmt->close();
$conn->close();
?>
