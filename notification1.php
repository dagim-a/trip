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
                    <a href="notification.php"><i class="fa-solid fa-bell"></i>
                        <span>Notification</span></a>
                </li>
                <li class="sidebar-item">
                    <a href="help.php"><i class="fa-solid fa-circle-question"></i>
                        <span>Help</span></a>
                </li>
            </ul>
        </aside>

        <main class="notification-content">
            <?php
            require 'cmsql.php';
            $user_id = $_SESSION['user_id'];
            $hasNotification = false;

            // 1. Show notifications for trip bookings
            $trip_result = mysqli_query($conn, "SELECT * FROM trip WHERE userId = $user_id");
            while ($trip = mysqli_fetch_assoc($trip_result)) {
                $trip_id = $trip['Id'];
                $trip_name = htmlspecialchars($trip['Trip_name']);

                $booking_result = mysqli_query($conn, "SELECT b.*, u.Name FROM booking b JOIN user_info u ON b.userId = u.userId WHERE b.TripId = $trip_id ORDER BY b.Id DESC");
                while ($booking = mysqli_fetch_assoc($booking_result)) {
                    if (!empty($booking['Name'])) {
                        $hasNotification = true;
                        $name = htmlspecialchars($booking['Name']);
                        echo '<div class="notification-card">';
                        echo '<div class="notification-info">';
                        echo '<div class="notification-icon"><i class="fa-solid fa-envelope-open-text"></i></div>';
                        echo '<div class="notification-text">';
                        echo '<p class="notification-title">' . $name . ' joined your trip: <b>' . $trip_name . '</b></p>';
                        echo '</div></div>';
                        echo '</div>';
                    }
                }
            }

            // 2. Show friend request notifications
            $friend_result = mysqli_query($conn, "SELECT * FROM notifications WHERE user_id = $user_id ORDER BY created_at DESC");
            while ($notification = mysqli_fetch_assoc($friend_result)) {
                $hasNotification = true;
                $message = htmlspecialchars($notification['message']);
                echo '<div class="notification-card">';
                echo '<div class="notification-info">';
                echo '<div class="notification-icon"><i class="fa-solid fa-user-plus"></i></div>';
                echo '<div class="notification-text">';
                echo '<p class="notification-title">' . $message . '</p>';
                echo '</div></div>';
                echo '</div>';
            }

            // Optional: Mark friend notifications as read
            mysqli_query($conn, "UPDATE notifications SET is_read = TRUE WHERE user_id = $user_id");

            // If no notifications found
            if (!$hasNotification) {
                echo '<h2 style="text-align:center; color:rgb(59, 55, 59); margin-top:40px;">No Notification</h2>';
            }
            ?>
        </main>
    </div>
</body>
</html>
