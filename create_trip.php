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
    // You can add file upload handling here if needed
    // Insert into database logic here (not implemented)
    $success = "Trip created successfully! (Demo only)";
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
        <div class="header-brand">
            <i class="fa-solid fa-tree"></i>
            <h1 class="header-title">Trip Planner</h1>
        </div>
        <nav class="header-nav">
            <ul class="nav-list">
                <li><a href="#" class="nav-link">Explore</a></li>
                <li><a href="#" class="nav-link">Trips</a></li>
                <li><a href="logout.php" class="nav-link">Log out</a></li>
                <li><i class="fa-solid fa-bell nav-bell"></i></li>
                <li><img src="images/Image 1.png" alt="Profile" class="nav-profile"></li>
            </ul>
        </nav>
    </header>
    <div class="main-container">
        <div class="trip-tabs">
            <button class="tab-btn active">Create Trip</button>
            <button class="tab-btn">My Trips</button>
        </div>
        <div class="trip-form-container">
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
    </div>
        <?php require 'footer.php'; ?>
</body>

</html>