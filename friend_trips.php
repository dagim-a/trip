<?php
// friend_trips.php
require_once 'cmsql.php';
$userId = isset($_GET['userId']) ? intval($_GET['userId']) : 0;
if ($userId) {
    $stmt = $conn->prepare('SELECT Name FROM user_info WHERE userId = ?');
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Collaborative Trips with Friend</title>
    <link rel="stylesheet" href="css/Search.css">
</head>
<body>
    <?php require 'Component/navbar.php'; ?>
    <div class="main-container" style="text-align:center; margin-top:60px;">
        <h2>Collaborative Trips with <?php echo htmlspecialchars($user['Name'] ?? 'Friend'); ?></h2>
        <p>Here you can plan and view trips together with your friend.</p>
        <ul style="list-style:none; padding:0; margin:32px auto; max-width:500px;">
        <?php
        // Example: List trips with this friend
        if ($userId) {
            $stmt = $conn->prepare('SELECT Trip_name, Id FROM Trip WHERE userId = ?');
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($trip = $result->fetch_assoc()) {
                echo '<li style="margin-bottom:18px;"><a href="trip_details.php?trip_id=' . $trip['Id'] . '" style="font-size:1.1rem; color:#007bff; text-decoration:none;">' . htmlspecialchars($trip['Trip_name']) . '</a></li>';
            }
        }
        ?>
        </ul>
        <a href="Search.php" class="btn" style="margin-top:24px;">Back to Search</a>
    </div>
    <?php require 'Component/footer.php'; ?>
</body>
</html>
