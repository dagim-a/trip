<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: home1.php");
    exit();
}
require 'cmsql.php';
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle trip deletion
    if (isset($_POST['delete_trip_id'])) {
        $delete_trip_id = intval($_POST['delete_trip_id']);
        $user_id = intval($_SESSION['user_id']);
        // Check if there are bookings for this trip
        $booking_check = $conn->prepare("SELECT COUNT(*) FROM booking WHERE TripId = ?");
        $booking_check->bind_param("i", $delete_trip_id);
        $booking_check->execute();
        $booking_check->bind_result($booking_count);
        $booking_check->fetch();
        $booking_check->close();
        if ($booking_count > 0) {
            $deletedMessage = "Cannot delete: This trip has existing bookings.";
        } else {
            $stmt = $conn->prepare("DELETE FROM trip WHERE Id = ? AND userId = ?");
            $stmt->bind_param("ii", $delete_trip_id, $user_id);
            if ($stmt->execute()) {
                $deletedMessage = "Trip deleted successfully!";
            } else {
                $deletedMessage = "Error deleting trip: " . $stmt->error;
            }
        }
    } else {
        // Handle trip creation
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
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Trip</title>
    <link rel="stylesheet" href="css/create_trip.css">
    <link rel="stylesheet" href="css/trip_detail_modal.css">
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
            <?php if (!empty($deletedMessage)) {
                echo '<div class="notice-message" style="color:green;">' . htmlspecialchars($deletedMessage) . '</div>';
            } ?>
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
                        $user_id = $_SESSION['user_id'];
                        $booking_result = mysqli_query($conn, "SELECT TripId FROM booking WHERE userId = $user_id");
                        $trip_ids = [];
                        while ($row = mysqli_fetch_assoc($booking_result)) {
                            $trip_ids[] = (int)$row['TripId'];
                        }
                        if (!empty($trip_ids)) {
                            foreach ($trip_ids as $trip_id) {
                                $trip_result = mysqli_query($conn, "SELECT * FROM trip WHERE Id = $trip_id");
                                if ($trip = mysqli_fetch_assoc($trip_result)) {
                                    $desc = htmlspecialchars($trip['Trip_description']);
                                    $img = isset($trip['img']) ? htmlspecialchars($trip['img']) : 'images/Image 1.png';
                                    $title = htmlspecialchars($trip['Trip_name']);
                                    echo "<div class='trip-list-item'>";
                                    echo "<img src='images/Image 1.png' alt='Profile' class='nav-profile'>";
                                    echo "<div class='trip-list-info'><div class='trip-list-name'><b>" . $title . "</b></div>";
                                    echo "<div class='trip-list-date'>" . htmlspecialchars($trip['Start_date']) . " to " . htmlspecialchars($trip['End_date']) . "</div>";
                                    echo "<div><button class='view-btn' 
                                                data-trip-id='" . $trip['Id'] . "'
                                                data-img='" . htmlspecialchars($trip['img']) . "'
                                                data-title='" . $title . "'
                                                data-destination='" . htmlspecialchars($trip['Destination']) . "'
                                                data-start='" . htmlspecialchars($trip['Start_date']) . "'
                                                data-end='" . htmlspecialchars($trip['End_date']) . "'
                                                data-desc='" . $desc . "'
                                                data-email='" . htmlspecialchars($trip['Email']) . "'
                                                data-transportation='" . htmlspecialchars($trip['transportation_type']) . "'
                                                data-travelers='" . htmlspecialchars($trip['Number_of_Travelers']) . "'
                                                data-cost='" . htmlspecialchars($trip['Trip_cost']) . "'
                                                data-status='" . htmlspecialchars($trip['status']) . "'
                                                style='border: none; padding: 7px 15px;'>View</button></div>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            }
                        }
                        ?>
                    </div>
                    <div class="trip-list-section" id="personalSection" style="display:none;">
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM trip WHERE userId = {$_SESSION['user_id']} AND (status = 'planned')");
                        while ($trip = mysqli_fetch_assoc($result)) {
                            $desc = htmlspecialchars($trip['Trip_description']);
                            $img = isset($trip['img']) ? htmlspecialchars($trip['img']) : 'images/Image 1.png';
                            $title = htmlspecialchars($trip['Trip_name']);
                            echo '<div class="trip-list-item">
                                <img src="images/Image 1.png" alt="Profile" class="nav-profile">
                                <div style="display:flex; flex-direction:row; justify-content:space-between; width:100%;">
                                    <div class="trip-list-info">
                                        <div class="trip-list-name"><b>' . $title . '</b></div>
                                        <div class="trip-list-date">' . htmlspecialchars($trip['Start_date']) . ' to ' . htmlspecialchars($trip['End_date']) . '</div>
                                    </div>
                                    <div style="display:flex; flex-direction: row; gap: 10px;">
                                        <button class="view-btn action-btn" title="View"
                                            data-trip-id="' . $trip['Id'] . '"
                                            data-img="' . htmlspecialchars($trip['img']) . '"
                                            data-title="' . $title . '"
                                            data-destination="' . htmlspecialchars($trip['Destination']) . '"
                                            data-start="' . htmlspecialchars($trip['Start_date']) . '"
                                            data-end="' . htmlspecialchars($trip['End_date']) . '"
                                            data-desc="' . $desc . '"
                                            data-email="' . htmlspecialchars($trip['Email']) . '"
                                            data-transportation="' . htmlspecialchars($trip['transportation_type']) . '"
                                            data-travelers="' . htmlspecialchars($trip['Number_of_Travelers']) . '"
                                            data-cost="' . htmlspecialchars($trip['Trip_cost']) . '"
                                            data-status="' . htmlspecialchars($trip['status']) . '">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <a href="edit_trip.php?trip_id=' . $trip['Id'] . '" class="edit-btn action-btn" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="delete_trip_id" value="' . $trip['Id'] . '">
                                            <button type="submit" class="delete-btn action-btn" title="Delete" onclick="return confirm(' . "'Are you sure you want to delete this trip?'" . ');">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>';
                        }
                        ?>
                    </div>
                    <div class="trip-list-section" id="closedSection" style="display:none;">
                        <?php
                        // Show all closed trips that the user has booked
                        $user_id = $_SESSION['user_id'];
                        $booking_result = mysqli_query($conn, "SELECT TripId FROM booking WHERE userId = $user_id");
                        $trip_ids = [];
                        while ($row = mysqli_fetch_assoc($booking_result)) {
                            $trip_ids[] = (int)$row['TripId'];
                        }
                        if (!empty($trip_ids)) {
                            foreach ($trip_ids as $trip_id) {
                                $trip_result = mysqli_query($conn, "SELECT Trip_name, Start_date, End_date, Trip_description, img FROM trip WHERE Id = $trip_id AND status = 'closed'");
                                if ($trip = mysqli_fetch_assoc($trip_result)) {
                                    $desc = htmlspecialchars($trip['Trip_description']);
                                    $img = isset($trip['img']) && $trip['img'] ? htmlspecialchars($trip['img']) : 'images/Image 1.png';
                                    $title = htmlspecialchars($trip['Trip_name']);
                                    echo "<div class='trip-list-item'>";
                                    echo "<img src='" . $img . "' alt='Profile' class='nav-profile'>";
                                    echo "<div class='trip-list-info'><div class='trip-list-name'><b>" . $title . "</b></div>";
                                    echo "<div class='trip-list-date'>" . htmlspecialchars($trip['Start_date']) . " to " . htmlspecialchars($trip['End_date']) . "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div></br></br>
    <script src="js/script.js"></script>

    <div id="descModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
        <div style="background:#fff; padding:30px; border-radius:10px; max-width:900px; margin:auto; position:relative; top:0vh; box-shadow:0 2px 16px rgba(0,0,0,0.2);">
            <span id="closeModal" style="position:absolute; top:10px; right:15px; font-size:22px; cursor:pointer;">&times;</span>
            <h3>Trip Details</h3>
            <div id="descContent" style="margin-top:15px; white-space:pre-line;"></div>
        </div>
    </div>
    <!-- Modal logic moved to js/script.js -->
    <?php require 'Component/footer.php'; ?>
</body>

</html>