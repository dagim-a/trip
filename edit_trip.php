<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: home1.php");
    exit();
}
require 'cmsql.php';

if (!isset($_GET['trip_id'])) {
    echo "Trip ID not specified.";
    exit();
}
$trip_id = intval($_GET['trip_id']);
$user_id = intval($_SESSION['user_id']);

// Fetch trip details
$stmt = $conn->prepare("SELECT * FROM trip WHERE Id = ? AND userId = ?");
$stmt->bind_param("ii", $trip_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$trip = $result->fetch_assoc();
if (!$trip) {
    echo "Trip not found or you do not have permission to edit this trip.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tripName = $_POST['tripName'] ?? '';
    $destination = $_POST['destination'] ?? '';
    $startDate = $_POST['startDate'] ?? '';
    $endDate = $_POST['endDate'] ?? '';
    $description = $_POST['description'] ?? '';
    $email = $_POST['email'] ?? '';
    $transportation = $_POST['transportation'] ?? '';
    $travelers = $_POST['travelers'] ?? '';
    $travelCost = $_POST['travel_cost'] ?? 0;
    $status = $_POST['status'] ?? $trip['status'];
    $img = $trip['img'];
    if (isset($_FILES['coverPhoto']) && $_FILES['coverPhoto']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'img/';
        $uploadFile = $uploadDir . basename($_FILES['coverPhoto']['name']);
        if (move_uploaded_file($_FILES['coverPhoto']['tmp_name'], $uploadFile)) {
            $img = $uploadFile;
        }
    }
    $stmt = $conn->prepare("UPDATE trip SET img=?, Trip_name=?, Destination=?, Start_date=?, End_date=?, Trip_description=?, Email=?, transportation_type=?, Number_of_Travelers=?, Trip_cost=?, status=? WHERE Id=? AND userId=?");
    $stmt->bind_param("ssssssssddssi", $img, $tripName, $destination, $startDate, $endDate, $description, $email, $transportation, $travelers, $travelCost, $status, $trip_id, $user_id);
    if ($stmt->execute()) {
        header("Location: create_trip.php?success=Trip updated successfully!");
        exit();
    } else {
        $error = "Error updating trip: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Trip</title>
    <link rel="stylesheet" href="css/create_trip.css">
</head>
<body>
<?php require 'Component/navbar.php'; ?>
<div class="main-container">
    <h2>Edit Trip</h2>
    <?php if (!empty($error)) echo '<div class="notice-message" style="color:red;">' . htmlspecialchars($error) . '</div>'; ?>
    <form class="trip-form" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Upload Cover Photo</label>
            <input type="file" name="coverPhoto" class="form-control">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="tripName">Trip Name</label>
                <input type="text" id="tripName" name="tripName" value="<?php echo htmlspecialchars($trip['Trip_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="destination">Destinations</label>
                <select id="destination" name="destination" required>
                    <option value="">Select</option>
                    <option value="Mexico" <?php if($trip['Destination']==='Mexico') echo 'selected'; ?>>Mexico</option>
                    <option value="Italy" <?php if($trip['Destination']==='Italy') echo 'selected'; ?>>Italy</option>
                    <option value="Japan" <?php if($trip['Destination']==='Japan') echo 'selected'; ?>>Japan</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="startDate">Start Date</label>
                <input type="date" id="startDate" name="startDate" value="<?php echo htmlspecialchars($trip['Start_date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="endDate">End Date</label>
                <input type="date" id="endDate" name="endDate" value="<?php echo htmlspecialchars($trip['End_date']); ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description"><?php echo htmlspecialchars($trip['Trip_description']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($trip['Email']); ?>" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="transportation">Transportation Type</label>
                <select id="transportation" name="transportation" required>
                    <option value="">Select</option>
                    <option value="Train" <?php if($trip['transportation_type']==='Train') echo 'selected'; ?>>Train</option>
                    <option value="Plane" <?php if($trip['transportation_type']==='Plane') echo 'selected'; ?>>Plane</option>
                    <option value="Car" <?php if($trip['transportation_type']==='Car') echo 'selected'; ?>>Car</option>
                </select>
            </div>
            <div class="form-group">
                <label for="travelers">Number of Travelers</label>
                <input type="number" id="travelers" name="travelers" min="1" value="<?php echo htmlspecialchars($trip['Number_of_Travelers']); ?>" required>
            </div>
            <div class="form-group">
                <label for="travel_cost">Travel Cost</label>
                <input type="number" id="travel_cost" name="travel_cost" min="1" value="<?php echo htmlspecialchars($trip['Trip_cost']); ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="planned" <?php if($trip['status']==='planned') echo 'selected'; ?>>Planned</option>
                <option value="closed" <?php if($trip['status']==='closed') echo 'selected'; ?>>Closed</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" class="save-btn">Update Trip</button>
            <a href="create_trip.php" class="cancel-btn" style="text-decoration:none;">Cancel</a>
        </div>
    </form>
</div>
<?php require 'Component/footer.php'; ?>
</body>
</html>
