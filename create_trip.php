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
    $coverPhoto = $_FILES['coverPhoto'] ?? null;
    $success = "Trip created successfully! (Demo only)";

    if ($coverPhoto && $coverPhoto['error'] === UPLOAD_ERR_OK) {
        // Handle file upload
        $uploadDir = 'img/';
        $uploadFile = $uploadDir . basename($coverPhoto['name']);
        if (move_uploaded_file($coverPhoto['tmp_name'], $uploadFile)) {

            $stmt = $conn->prepare("INSERT INTO Trip (img, Trip_name, Destination, Start_date, End_date, Trip_description, Email, transportation_type, Number_of_Travelers, userId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssisssi", $uploadFile, $tripName, $destination, $startDate, $endDate, $description, $email, $transportation, $travelers, $_SESSION['user_id']);
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
    <link rel="stylesheet" href="create_trip.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>
    <header class="header">
        <a href="home1.php"><div class="header-brand">
            <i class="fa-solid fa-tree"></i>
            <h1 class="header-title">Trip Planner</h1>
        </div></a>
        <nav class="header-nav">
            <ul class="nav-list">
                <li><a href="#" class="nav-link">Explore</a></li>
                <li><a href="create_trip.php" class="nav-link">Trips</a></li>
                <li><a href="logout.php" class="nav-link">Log out</a></li>
                <li><a href="notification1.php"><i class="fa-solid fa-bell nav-bell"></i></a></li>
                <li><a href="edit1.php"><img src="images/Image 1.png" alt="Profile" class="nav-profile"></a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="header-page">
            <h2>Create a Trip</h2>
            <p>Plan your next adventure with us!</p>
        </div>
    </main>
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
                </div>
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
    </div>
    <?php require 'footer.php'; ?>
    <script>
        // Main tab switching logic
        const createTripTab = document.getElementById('createTripTab');
        const myTripsTab = document.getElementById('myTripsTab');
        const tripFormContainer = document.getElementById('tripFormContainer');
        const tripListContainer = document.getElementById('tripListContainer');

        createTripTab.addEventListener('click', function() {
            createTripTab.classList.add('active');
            myTripsTab.classList.remove('active');
            tripFormContainer.style.display = '';
            tripListContainer.style.display = 'none';
        });
        myTripsTab.addEventListener('click', function() {
            myTripsTab.classList.add('active');
            createTripTab.classList.remove('active');
            tripFormContainer.style.display = 'none';
            tripListContainer.style.display = '';
        });

        // Trip list tab switching logic
        const upcomingTab = document.getElementById('upcomingTab');
        const personalTab = document.getElementById('personalTab');
        const closedTab = document.getElementById('closedTab');
        const upcomingSection = document.getElementById('upcomingSection');
        const personalSection = document.getElementById('personalSection');
        const closedSection = document.getElementById('closedSection');

        function showTripSection(tab, section) {
            // Remove active from all
            upcomingTab.classList.remove('trip-list-tab-active');
            personalTab.classList.remove('trip-list-tab-active');
            closedTab.classList.remove('trip-list-tab-active');
            upcomingSection.style.display = 'none';
            personalSection.style.display = 'none';
            closedSection.style.display = 'none';
            // Add active to selected
            tab.classList.add('trip-list-tab-active');
            section.style.display = '';
        }
        upcomingTab.addEventListener('click', function() {
            showTripSection(upcomingTab, upcomingSection);
        });
        personalTab.addEventListener('click', function() {
            showTripSection(personalTab, personalSection);
        });
        closedTab.addEventListener('click', function() {
            showTripSection(closedTab, closedSection);
        });
    </script>
</body>

</html>