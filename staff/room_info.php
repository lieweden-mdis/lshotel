<?php
include 'staff_header.php';
include '../config.php';

// Fetch room data from the database
$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);

$rooms = array();
$all_features = array();
$all_facilities = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;

        // Collect all features and facilities
        $features = explode(', ', $row['room_features']);
        $facilities = explode(', ', $row['room_facilities']);
        $all_features = array_merge($all_features, $features);
        $all_facilities = array_merge($all_facilities, $facilities);
    }
}

$conn->close();

// Remove duplicate values
$all_features = array_unique($all_features);
$all_facilities = array_unique($all_facilities);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config.php';

    $room_id = $_POST['room_id'];
    $room_level = $_POST['room_level'];
    $room_price = $_POST['room_price'];
    $room_features = $_POST['room_features'];
    $room_facilities = $_POST['room_facilities'];
    $room_size = $_POST['room_size'];
    $room_availability = $_POST['room_availability'];
    $room_description = $_POST['room_description'];

    $sql = "UPDATE rooms SET 
                room_level = ?, 
                room_price = ?, 
                room_features = ?, 
                room_facilities = ?, 
                room_size = ?, 
                room_availability = ?, 
                room_description = ? 
            WHERE room_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idsssisi", $room_level, $room_price, $room_features, $room_facilities, $room_size, $room_availability, $room_description, $room_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/staff/staff-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/staff/room-info.css?v=<?php echo time(); ?>">
    <title>L's HOTEL - ROOM INFO</title>
    <link rel="icon" href="../img/icon.jpg">

</head>
<body>
    <div class="staff-container">
        <?php include 'staff_sidenav.php'; ?>
        <div class="main">
            <div class="staff-page-title">
                <span>Room Info</span>
            </div>

            <div class="table-wrapper">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Level</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="roomTableBody">
                        <!-- Dynamic rows will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoomModalLabel">Edit Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editRoomForm">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="roomID">Room ID</label>
                                <input type="text" class="form-control" id="roomID" name="roomID" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="roomType">Room Type</label>
                                <input type="text" class="form-control" id="roomType" name="roomType" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="roomLevel">Room Level</label>
                                <input type="number" class="form-control" id="roomLevel" name="roomLevel">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="roomPrice">Room Price</label>
                                <input type="number" class="form-control" id="roomPrice" name="roomPrice" step="0.01">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="roomFeatures">Room Features</label>
                            <div id="roomFeatures" class="checkbox-grid">
                                <?php foreach ($all_features as $feature): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="feature-<?php echo htmlspecialchars($feature); ?>" value="<?php echo htmlspecialchars($feature); ?>">
                                        <label class="form-check-label" for="feature-<?php echo htmlspecialchars($feature); ?>">
                                            <?php echo htmlspecialchars($feature); ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="additional-spacing">
                                <label for="additionalRoomFeatures">Additional Features (comma-separated)</label>
                                <textarea class="form-control" id="additionalRoomFeatures" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="roomFacilities">Room Facilities</label>
                            <div id="roomFacilities" class="checkbox-grid">
                                <?php foreach ($all_facilities as $facility): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="facility-<?php echo htmlspecialchars($facility); ?>" value="<?php echo htmlspecialchars($facility); ?>">
                                        <label class="form-check-label" for="facility-<?php echo htmlspecialchars($facility); ?>">
                                            <?php echo htmlspecialchars($facility); ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="additional-spacing">
                                <label for="additionalRoomFacilities">Additional Facilities (comma-separated)</label>
                                <textarea class="form-control" id="additionalRoomFacilities" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="roomSize">Room Size</label>
                            <input type="text" class="form-control" id="roomSize" name="roomSize">
                        </div>
                        <div class="form-group">
                            <label for="roomAvailability">Room Availability</label>
                            <input type="number" class="form-control" id="roomAvailability" name="roomAvailability">
                        </div>
                        <div class="form-group">
                            <label for="roomDescription">Room Description</label>
                            <textarea class="form-control" id="roomDescription" name="roomDescription" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="roomImage">Room Images</label>
                            <div class="image-preview" id="roomImagePreview"></div>
                        </div>
                    </form>
                    <div id="successMessage" class="alert alert-success" style="display: none;">
                        Room updated successfully!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="updateButton">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelButton">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy;2024 L's Hotel All Right Reserved.</p>
    </footer>
    <script>
        const roomData = <?php echo json_encode($rooms); ?>;
        console.log("Fetched Room Data:", roomData);

        function populateTable(roomData) {
            const tableBody = document.getElementById('roomTableBody');
            tableBody.innerHTML = '';

            if (!roomData || roomData.length === 0) {
                console.error("No room data found");
                return;
            }

            roomData.forEach((room) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${room.room_id}</td>
                    <td>${room.room_type}</td>
                    <td>${room.room_size}</td>
                    <td>${room.room_level}</td>
                    <td>${Number(room.room_price).toFixed(2)}</td>
                    <td>${room.room_availability}</td>
                    <td class="action-buttons">
                        <button class="btn btn-primary btn-sm" onclick="openEditModal(${room.room_id})">Edit</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            console.log("Table populated successfully");
        }

        function openEditModal(roomID) {
            const room = roomData.find(r => r.room_id == roomID);

            document.getElementById('roomID').value = room.room_id;
            document.getElementById('roomType').value = room.room_type;
            document.getElementById('roomLevel').value = room.room_level;
            document.getElementById('roomPrice').value = room.room_price;
            document.getElementById('roomSize').value = room.room_size;
            document.getElementById('roomAvailability').value = room.room_availability;
            document.getElementById('roomDescription').value = room.room_description;

            // Set the checkboxes for features and facilities
            const roomFeatures = room.room_features.split(', ');
            document.querySelectorAll('#roomFeatures .form-check-input').forEach(checkbox => {
                checkbox.checked = roomFeatures.includes(checkbox.value);
            });

            const roomFacilities = room.room_facilities.split(', ');
            document.querySelectorAll('#roomFacilities .form-check-input').forEach(checkbox => {
                checkbox.checked = roomFacilities.includes(checkbox.value);
            });

            // Display additional features and facilities
            const additionalFeatures = roomFeatures.filter(f => ![...document.querySelectorAll('#roomFeatures .form-check-input')].map(cb => cb.value).includes(f));
            document.getElementById('additionalRoomFeatures').value = additionalFeatures.join(', ');

            const additionalFacilities = roomFacilities.filter(f => ![...document.querySelectorAll('#roomFacilities .form-check-input')].map(cb => cb.value).includes(f));
            document.getElementById('additionalRoomFacilities').value = additionalFacilities.join(', ');

            // Display room images
            const roomImagePreview = document.getElementById('roomImagePreview');
            roomImagePreview.innerHTML = '';
            const images = room.room_images.split(',');
            images.forEach((image, index) => {
                const imgElement = document.createElement('img');
                imgElement.src = `../img/room-image/${room.room_type.toLowerCase().replace(/ /g, '-')}/${image.trim()}`;
                imgElement.alt = `roomimg${index + 1}`;
                roomImagePreview.appendChild(imgElement);
            });

            document.getElementById('successMessage').style.display = 'none';
            $('#editRoomModal').modal('show');
        }

        function updateRoom() {
            const roomID = document.getElementById('roomID').value;

            // Get selected features and facilities
            const selectedFeatures = Array.from(document.querySelectorAll('#roomFeatures .form-check-input:checked')).map(cb => cb.value);
            const additionalFeatures = document.getElementById('additionalRoomFeatures').value.split(',').map(f => f.trim()).filter(f => f);
            const allFeatures = [...new Set([...selectedFeatures, ...additionalFeatures])];

            const selectedFacilities = Array.from(document.querySelectorAll('#roomFacilities .form-check-input:checked')).map(cb => cb.value);
            const additionalFacilities = document.getElementById('additionalRoomFacilities').value.split(',').map(f => f.trim()).filter(f => f);
            const allFacilities = [...new Set([...selectedFacilities, ...additionalFacilities])];

            const updatedRoom = {
                room_id: roomID,
                room_level: document.getElementById('roomLevel').value,
                room_price: document.getElementById('roomPrice').value,
                room_features: allFeatures.join(', '),
                room_facilities: allFacilities.join(', '),
                room_size: document.getElementById('roomSize').value,
                room_availability: document.getElementById('roomAvailability').value,
                room_description: document.getElementById('roomDescription').value,
            };

            console.log("Updating room:", updatedRoom);

            $.ajax({
                url: 'room_info.php',
                type: 'POST',
                data: updatedRoom,
                success: function(response) {
                    if (response === 'success') {
                        document.getElementById('successMessage').style.display = 'block';
                        setTimeout(() => {
                            $('#editRoomModal').modal('hide');
                            location.reload();
                        }, 2000);
                    } else {
                        alert('Failed to update room.');
                    }
                },
                error: function() {
                    alert('Failed to update room.');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            populateTable(roomData);
            document.getElementById('updateButton').addEventListener('click', updateRoom);
            document.getElementById('cancelButton').addEventListener('click', () => {
                document.getElementById('editRoomForm').reset();
                document.getElementById('successMessage').style.display = 'none';
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
