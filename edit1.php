<?php
if (isset($_GET['success'])) {
    $success = $_GET['success'];
}
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: home1.php");
    exit();
}
require 'cmsql.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="css/edit1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <header class="header">
        <a href="home1.php">
            <div class="header-brand">
                <i class="fa-solid fa-tree"></i>
                <h1 class="header-title">Trip Planner</h1>
            </div>
        </a>
        <nav class="header-nav">
            <ul class="nav-list">
                <li><a href="#" class="nav-link">Explore</a></li>
                <li><a href="create_trip.php" class="nav-link">Trips</a></li>
                <li><a href="logout.php" class="nav-link">Log out</a></li>
                <li><a href="notification1.php"><i class="fa-solid fa-bell nav-bell"></i></a></li>
                <li><img src="images/Image 1.png" alt="Profile" class="nav-profile"></li>
            </ul>
        </nav>
    </header>

    <div class="main-container">
        <aside class="sidebar">
            <ul class="sidebar-list">
                <li class="sidebar-item">
                    <a href="edit1.php"><i class="fa-solid fa-pencil"></i>
                        <span>Edit profile</span></a>
                </li>
                <li class="sidebar-item">
                    <a href="notification1.php"><i class="fa-solid fa-bell"></i>
                        <span>Notification</span></a>
                </li>
                <li class="sidebar-item">
                    <a href="#"><i class="fa-solid fa-circle-question"></i>
                        <span>Help</span></a>
                </li>
            </ul>
        </aside>
        <main class="content">
            <button class="hamburger" aria-label="Open menu">&#9776;</button>
            <h1 class="content-title">Account</h1>
            <div class="profile-section">
                <img src="images/Image 1.png" alt="Profile Picture" class="profile-img">
                <div>
                    <h2 class="profile-name">
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM user_info WHERE userId = {$_SESSION['user_id']}");
                        $user_info = mysqli_fetch_assoc($result);
                        echo $user_info['Name'];
                        ?>
                    </h2>
                    <p class="profile-email">
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM user WHERE Id = {$_SESSION['user_id']}");
                        $user = mysqli_fetch_assoc($result);
                        echo $user['Email'];

                        ?>
                    </p>
                </div>
            </div>
            <div class="stats-section">
                <div class="stats-card">
                    <h3>Trips Taken</h3>
                    <p class="stats-value">
                        <?php
                        echo $user_info['Trip_taken'];
                        ?>
                    </p>
                </div>
                <div class="stats-card">
                    <h3>Traveler Level</h3>
                    <p class="stats-value">
                        <?php
                        echo $user_info['Travel_level'];
                        ?>
                    </p>
                </div>
            </div>
            <h2 class="section-title">Account Settings</h2>
            <form class="settings-form" method="POST" action="update_profile.php">

                <div class="form-group">
                    <label for="displayName">Display Name (required)</label>
                    <input type="text" id="displayName" name="displayName" required>
                </div>
                <div class="form-group">
                    <label for="email">Email (required)</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="country">Country (required)</label>
                    <input type="text" id="country" name="country" required>
                </div>
                <div class="form-group">
                    <label for="phoneNumber">Phone Number</label>
                    <input type="tel" id="phoneNumber" name="phoneNumber">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                </div>
                <div>
                    <?php if (!empty($success)) {
                        echo '<div class="notice-message" style="color:green;">' . htmlspecialchars($success) . '</div>';
                    } ?>
                </div>
                <button type="submit" class="update-btn">Update</button>
            </form>
            <h2 class="section-title">Favorite Destinations</h2>
            <p>Favorite Destinations</p>
            <input type="text" id="favoriteDestinations" name="favoriteDestinations" class="single-input">
            <h2 class="section-title">Travel Preferences</h2>
            <p>Interests</p>
            <input type="text" id="interests" name="interests" class="single-input">
        </main>
    </div>
</body>

</html>