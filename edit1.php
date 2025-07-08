<?php
session_start();
require 'cmsql.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="edit1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
        <aside class="sidebar">
            <ul class="sidebar-list">
                <li class="sidebar-item">
                    <i class="fa-solid fa-pencil"></i>
                    <span>Edit profile</span>
                </li>
                <li class="sidebar-item">
                    <i class="fa-solid fa-bell"></i>
                    <span>Notification</span>
                </li>
                <li class="sidebar-item">
                    <i class="fa-solid fa-circle-question"></i>
                    <span>Help</span>
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
                    <label for="displayName">Display Name</label>
                    <input type="text" id="displayName" name="displayName">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" id="country" name="country">
                </div>
                <div class="form-group">
                    <label for="phoneNumber">Phone Number</label>
                    <input type="tel" id="phoneNumber" name="phoneNumber">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
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
    <nav class="mobile-bottom-nav">
      <a href="#" class="mobile-nav-item">
        <i class="fa-solid fa-compass"></i>
        <span class="mobile-nav-label">Explore</span>
      </a>
      <a href="#" class="mobile-nav-item">
        <i class="fa-solid fa-suitcase"></i>
        <span class="mobile-nav-label">Trip</span>
      </a>
      <a href="#" class="mobile-nav-item">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span class="mobile-nav-label">Log out</span>
      </a>
    </nav>
</body>
</html>
