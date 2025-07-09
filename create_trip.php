<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: home1.php");
    exit();
}
require 'cmsql.php';
// Handle form submission
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
    $coverPhoto = $_FILES['coverPhoto'] ?? null;
    $success = "Trip created successfully! (Demo only)";

    if ($coverPhoto && $coverPhoto['error'] === UPLOAD_ERR_OK) {
        // Handle file upload
        $uploadDir = 'img/';
        $uploadFile = $uploadDir . basename($coverPhoto['name']);
        if (move_uploaded_file($coverPhoto['tmp_name'], $uploadFile)) {

            $stmt = $conn->prepare("INSERT INTO Trip (img, Trip_name, Destination, Start_date, End_date, Trip_description, Email, transportation_type, Number_of_Travelers, Trip_cost, userId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssisssid", $uploadFile, $tripName, $destination, $startDate, $endDate, $description, $email, $transportation, $travelers, $travelCost, $_SESSION['user_id']);
            if ($stmt->execute()) {
                $success = "Trip created successfully!";
            } else {
                echo "Error saving trip: " . $stmt->error;
            }
        } else {
            echo "Error uploading file.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Trip</title>
    <link rel="stylesheet" href="css/create_trip.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>
    <?php require 'Component/navbar.php'; ?>

    <div class="main-container">
        <div class="trip-tabs">
            <button class="tab-btn active" id="createTripTab">Create Trip</button>
            <button class="tab-btn" id="myTripsTab">My Trips</button>
        </div>
        <div class="trip-form-container" id="tripFormContainer">
            <?php if (!empty($success)) {
                echo '<div class="notice-message" style="color:green;">' . htmlspecialchars($success) . '</div>';
            } ?>
            <form class="trip-form" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Upload Cover Photo</label>
                    <input type="file" name="coverPhoto" class="form-control">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="tripName">Trip Name</label>
                        <input type="text" id="tripName" name="tripName" required>
                    </div>
                    <div class="form-group">
                        <label for="destination">Destinations</label>
                        <select id="destination" name="destination" required>
                            <option value="">Select</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Italy">Italy</option>
                            <option value="Japan">Japan</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" id="startDate" name="startDate" required>
                    </div>
                    <div class="form-group">
                        <label for="endDate">End Date</label>
                        <input type="date" id="endDate" name="endDate" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="transportation">Transportation Type</label>
                        <select id="transportation" name="transportation" required>
                            <option value="">Select</option>
                            <option value="Train">Train</option>
                            <option value="Plane">Plane</option>
                            <option value="Car">Car</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="travelers">Number of Travelers</label>
                        <input type="number" id="travelers" name="travelers" min="1" value="1" required>
                    </div>
                    <div class="form-group">
                        <label for="travel_cost">Travel Cost</label>
                        <input type="number" id="travel_cost" name="travel_cost" min="1" value="200" required>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="save-btn">Save</button>
                    <button type="reset" class="cancel-btn">Cancel</button>
                </div>
            </form>
        </div>

        <div class="trip-list-container" id="tripListContainer" style="display:none;">
            <div class="trip-list-card">
                <h2 class="trip-list-title">ACTIVE TRIPS</h2>
                <div class="trip-list-tabs">
                    <button class="trip-list-tab trip-list-tab-active" id="upcomingTab">Upcoming Events</button>
                    <button class="trip-list-tab" id="personalTab">Personal Trip</button>
                    <button class="trip-list-tab" id="closedTab">Closed Trip</button>
                </div></br>
                <div class="trip-list-content">
                    <div class="trip-list-section" id="upcomingSection">
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM trip WHERE userId = {$_SESSION['user_id']} AND (status = 'planned' OR status = 'upcoming')");
                        while ($trip = mysqli_fetch_assoc($result)) {
                            echo "<div class='trip-list-item'>";
                            echo "<img src='images/Image 1.png' alt='Profile' class='nav-profile'>";
                            echo "<div class='trip-list-info'><div class='trip-list-name'><b>{$trip['Trip_name']}</b></div>";
                            echo "<div class='trip-list-date'>{$trip['Start_date']} - {$trip['End_date']}</div></div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                    <div class="trip-list-section" id="personalSection" style="display:none;">
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM trip WHERE userId = {$_SESSION['user_id']} AND status = 'planned'");
                        while ($trip = mysqli_fetch_assoc($result)) {
                            echo "<div class='trip-list-item'>";
                            echo "<img src='images/Image 1.png' alt='Profile' class='nav-profile'>";
                            echo "<div class='trip-list-info'><div class='trip-list-name'><b>{$trip['Trip_name']}</b></div>";
                            echo "<div class='trip-list-date'>{$trip['Start_date']} - {$trip['End_date']}</div></div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                    <div class="trip-list-section" id="closedSection" style="display:none;">
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM trip WHERE userId = {$_SESSION['user_id']} AND status = 'closed'");
                        while ($trip = mysqli_fetch_assoc($result)) {
                            echo "<div class='trip-list-item'>";
                            echo "<img src='images/Image 1.png' alt='Profile' class='nav-profile'>";
                            echo "<div class='trip-list-info'><div class='trip-list-name'><b>{$trip['Trip_name']}</b></div>";
                            echo "<div class='trip-list-date'>{$trip['Start_date']} - {$trip['End_date']}</div></div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div></br></br>
    <script src="js/script.js"></script>
    <?php require 'Component/footer.php'; ?>
</body>

</html>