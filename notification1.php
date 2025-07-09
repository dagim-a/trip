<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: home1.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
    <link rel="stylesheet" href="css/notification1.css">
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
                    <a href="#"><i class="fa-solid fa-circle-question"></i>
                    <span>Help</span></a>
                </li>
            </ul>
        </aside>
        <main class="notification-content">
            <div class="notification-card">
                <div class="notification-info">
                    <div class="notification-icon">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </div>
                    <div>
                        <p class="notification-title">You've been invited to a trip</p>
                        <p class="notification-desc">Trip to Italy</p>
                    </div>
                </div>
                <button class="notification-btn">View</button>
            </div>
        </main>
    </div>

</body>
</html>
