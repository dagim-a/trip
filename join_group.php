<?php
require 'cmsql.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Error: You must be logged in.";
    exit;
}

$senderId = intval($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
    $receiverId = intval($_POST['userId']);

    // Check if receiver exists and get their name
    $checkUser = "SELECT Name FROM user_info WHERE userId = $receiverId";
    $userResult = mysqli_query($conn, $checkUser);

    if (!$userResult || mysqli_num_rows($userResult) === 0) {
        echo "Error: The user you’re trying to notify does not exist.";
        exit;
    }
    $receiverData = mysqli_fetch_assoc($userResult);
    $receiverName = $receiverData['Name'];

    // Get sender's name
    $senderQuery = mysqli_query($conn, "SELECT Name FROM user_info WHERE userId = $senderId");
    $senderData = mysqli_fetch_assoc($senderQuery);
    $senderName = $senderData['Name'] ?? 'Someone';

    // Prepare and insert notification
    $message = "$senderName requested to join your group.";

    $insert = "INSERT INTO notifications (user_id, message, is_read, created_at) 
               VALUES ($receiverId, '$message', FALSE, NOW())";

    if (mysqli_query($conn, $insert)) {
        echo "Join group request sent to $receiverName.";
    } else {
        echo "Database error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
