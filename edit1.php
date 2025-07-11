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
    <?php require 'Component/navbar.php'; ?>
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
                    <a href="help.php"><i class="fa-solid fa-circle-question"></i>
                        <span>Help</span></a>
                </li>
            </ul>
        </aside>
        <main class="content">
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
                        $trips_taken = $user_info['Trip_taken'];

                        if ($trips_taken < 10) {
                            $medal = "🥉 Bronze Explorer";
                        } elseif ($trips_taken < 20) {
                            $medal = "🥈 Silver Voyager";
                        } elseif ($trips_taken >= 20) {
                            $medal = "🥇 Gold Trailblazer";
                        } else {
                            $medal = "Unknown";
                        }

                        echo "<p class='stats-value'>$medal</p>";
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
            <form action="delete.php" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                <button type="submit" class="delete-btn">DELETE ACCOUNT</button>
            </form>

        </main>
        <!-- Mobile Bottom Navigation Bar -->
        <nav class="mobile-bottom-nav" id="mobileBottomNav">
            <a href="edit1.php" class="mobile-nav-item">
                <i class="fa-solid fa-pencil"></i>
                <span>Edit</span>
            </a>
            <a href="notification1.php" class="mobile-nav-item">
                <i class="fa-solid fa-bell"></i>
                <span>Notify</span>
            </a>
            <a href="help.php" class="mobile-nav-item">
                <i class="fa-solid fa-circle-question"></i>
                <span>Help</span>
            </a>
        </nav>
    </div>
</body>

</html>