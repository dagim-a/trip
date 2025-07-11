<?php
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
    <title>Help Center</title>
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
                    <a href="help.php" class="active"><i class="fa-solid fa-circle-question"></i>
                        <span>Help</span></a>
                </li>
            </ul>
        </aside>

        <main class="content">
            <h1 class="content-title"><i class="fa-solid fa-circle-question"></i> Help Center</h1>
            <p class="intro-text">Here you'll find guidance on using your account and making the most of your travel planner. If something isn’t working as expected, we’re here to help!</p>

            <div class="help-section">
                <ul class="help-list">
                    <li><strong>✏️ Editing Your Profile:</strong> Update your name, email, and other personal info from the <a href="edit1.php">Edit Profile</a> section.</li>
                    <li><strong>🔒 Resetting Your Password:</strong> Click on “Forgot password?” on the login page or contact support for help.</li>
                    <li><strong>🌍 Updating Country & Preferences:</strong> Keep your travel preferences accurate for better suggestions.</li>
                    <li><strong>📨 Managing Notifications:</strong> Visit the <a href="notification1.php">Notifications</a> page to adjust what updates you receive.</li>
                    <li><strong>💬 Need More Help?</strong> Reach us via email at <a href="mailto:KoDaH@gmail.com">KoDaH@gmail.com</a> and we'll respond as soon as possible.</li>
                </ul>
                <p class="tip-message">✨ Tip: You can also browse our FAQ section and chat with support during business hours.</p>
            </div>

            <div class="contact-form">
                <h3>Contact Support Directly</h3>
                <p>If you'd prefer to message us right here, fill out the form below:</p>
                <form action="send_support_message.php" method="POST">
                    <div class="form-group">
                        <label for="userEmail">Your Email</label>
                        <input type="email" id="userEmail" name="userEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="update-btn">Send Message</button>
                </form>
            </div>

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