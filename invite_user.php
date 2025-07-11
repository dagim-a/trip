<?php
// invite_user.php
// Handles inviting a user to a trip and creating a notification for the invitee

require_once 'cmsql.php'; // Assumes this file contains DB connection logic
session_start();

header('Content-Type: application/json');

// Read JSON input
$input = json_decode(file_get_contents('php://input'), true);
$trip_id = isset($input['trip_id']) ? intval($input['trip_id']) : 0;
$invitee_email = isset($input['email']) ? trim($input['email']) : '';
$inviter_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

if (!$trip_id || !$invitee_email || !$inviter_id) {
    echo json_encode(['success' => false, 'message' => 'Missing required data.']);
    exit;
}

// Find invitee user by email
$sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $invitee_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
    exit;
}

$invitee = $result->fetch_assoc();
$invitee_id = $invitee['id'];

// Check if already invited
$sql = "SELECT id FROM trip_invitations WHERE trip_id = ? AND invitee_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $trip_id, $invitee_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'User already invited.']);
    exit;
}

// Insert invitation
$sql = "INSERT INTO trip_invitations (trip_id, inviter_id, invitee_id, invited_at) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param('iii', $trip_id, $inviter_id, $invitee_id);
$stmt->execute();

// Create notification for invitee
$notification = "You have been invited to join a trip.";
$sql = "INSERT INTO notifications (user_id, message, created_at, is_read) VALUES (?, ?, NOW(), 0)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $invitee_id, $notification);
$stmt->execute();

// Success response
echo json_encode(['success' => true, 'message' => 'Invitation sent and notification created.']);
