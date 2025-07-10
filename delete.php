<?php
session_start();
require 'cmsql.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: home1.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Step 1: Check if user has trips
$query = "SELECT Trip_taken FROM user_info WHERE userId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_info = $result->fetch_assoc();

if ($user_info && $user_info['Trip_taken'] > 0) {
    // User has trips — do NOT delete
    header("Location: edit1.php?success=" . urlencode("Cannot delete account. You have existing trips."));
    exit();
}

// Step 2: Delete from user_info and user tables (adjust if there are other dependencies)
$conn->begin_transaction();

try {
    $stmt1 = $conn->prepare("DELETE FROM user_info WHERE userId = ?");
    $stmt1->bind_param("i", $user_id);
    $stmt1->execute();

    $stmt2 = $conn->prepare("DELETE FROM user WHERE Id = ?");
    $stmt2->bind_param("i", $user_id);
    $stmt2->execute();

    $conn->commit();

    // Destroy session and redirect
    session_destroy();
    header("Location: home1.php?success=" . urlencode("Account deleted successfully."));
    exit();

} catch (Exception $e) {
    $conn->rollback();
    header("Location: edit1.php?success=" . urlencode("An error occurred. Please try again."));
    exit();
}
?>
