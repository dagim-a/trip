<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    require 'cmsql.php';

    $displayName = $_POST['displayName'] ?? '';
    $email = $_POST['email'] ?? '';
    $country = $_POST['country'] ?? '';
    $phoneNumber = $_POST['phoneNumber'] ?? '';
    $password = $_POST['password'] ?? '';
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Update user profile in the database
        $stmt1 = $conn->prepare("UPDATE user SET Email=?, Password_hash=? WHERE Id=?");
        $stmt1->bind_param("ssi", $email, $hashedPassword, $userId);

        $stmt2 = $conn->prepare("UPDATE user_info SET Name=?, Country=?, Phone=? WHERE userId=?");
        $stmt2->bind_param("sssi", $displayName, $country, $phoneNumber, $userId);

        if ($stmt1->execute() && $stmt2->execute()) {
            echo "Profile updated successfully.";
        } else {
            echo "Error updating profile: " . $stmt1->error;
            echo "Error updating profile: " . $stmt2->error;
        }

        $stmt1->close();
        $stmt2->close();
    } else {
        echo "User not logged in.";
    }
}
