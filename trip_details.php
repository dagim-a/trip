<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: signin1.php");
    exit();
}
require 'cmsql.php';
if (!isset($_POST['trip_id'])) {
    echo '<div style="color:red;">No trip selected.</div>';
    exit();
}
$trip_id = intval($_POST['trip_id']);
$user_id = $_SESSION['user_id'];
// Only allow access to trips the user owns or has booked
$trip = null;
// Check if user owns the trip
$result = $conn->prepare("SELECT * FROM trip WHERE Id = ? AND userId = ?");
$result->bind_param("ii", $trip_id, $user_id);
$result->execute();
$res = $result->get_result();
if ($res->num_rows > 0) {
    $trip = $res->fetch_assoc();
} else {
    // Check if user has booked this trip
    $result2 = $conn->prepare("SELECT t.* FROM trip t JOIN booking b ON t.Id = b.TripId WHERE t.Id = ? AND b.userId = ?");
    $result2->bind_param("ii", $trip_id, $user_id);
    $result2->execute();
    $res2 = $result2->get_result();
    if ($res2->num_rows > 0) {
        $trip = $res2->fetch_assoc();
    }
}
if (!$trip) {
    echo '<div style="color:red;">Trip not found or access denied.</div>';
    exit();
}
$img = isset($trip['img']) && $trip['img'] ? htmlspecialchars($trip['img']) : 'images/Image 1.png';
echo '
<div style="display:flex; gap:30px; align-items:flex-start;">
    <img src="' . $img . '" alt="Trip Cover" style="width:220px; height:160px; object-fit:cover; border-radius:8px;">
    <div>
        <h2 style="margin-top:10;">' . htmlspecialchars($trip['Trip_name']) . '</h2>
        <p><b>Destination1:</b> ' . htmlspecialchars($trip['Destination']) . '</p>
        <p><b>Start Date:</b> ' . htmlspecialchars($trip['Start_date']) . '</p>
        <p><b>End Date:</b> ' . htmlspecialchars($trip['End_date']) . '</p>
        <p><b>Description:</b><br>' . nl2br(htmlspecialchars($trip['Trip_description'])) . '</p>
        <p><b>Email:</b> ' . htmlspecialchars($trip['Email']) . '</p>
        <p><b>Transportation:</b> ' . htmlspecialchars($trip['transportation_type']) . '</p>
        <p><b>Number of Travelers:</b> ' . htmlspecialchars($trip['Number_of_Travelers']) . '</p>
        <p><b>Trip Cost:</b> $' . htmlspecialchars($trip['Trip_cost']) . '</p>
        <p><b>Status:</b> ' . htmlspecialchars($trip['status']) . '</p>
    </div>
</div>';
