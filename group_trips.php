<?php
// group_trips.php
require_once 'cmsql.php';
$groupId = isset($_GET['groupId']) ? intval($_GET['groupId']) : 0;
if ($groupId) {
    $stmt = $conn->prepare('SELECT Name FROM user_info WHERE userId = ?');
    $stmt->bind_param('i', $groupId);
    $stmt->execute();
    $result = $stmt->get_result();
    $group = $result->fetch_assoc();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: signin1.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Group Collaborative Trips</title>
    <link rel="stylesheet" href="css/Search.css">
</head>
<body>
    <?php require 'Component/navbar.php'; ?>
    <div class="main-container" style="text-align:center; margin-top:60px;">
        <h2>Group Collaborative Trips with <?php echo htmlspecialchars($group['Name'] ?? 'Group'); ?></h2>
        <p>Here you can plan and view trips together as a group.</p>
        <ul style="list-style:none; padding:0; margin:32px auto; max-width:500px;">
        <?php
        // Example: List group members
        if ($groupId) {
            $stmt = $conn->prepare('SELECT user_info.Name, group_members.user_id FROM group_members JOIN user_info ON group_members.user_id = user_info.userId WHERE group_members.group_id = ?');
            $stmt->bind_param('i', $groupId);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($member = $result->fetch_assoc()) {
                echo '<li style="margin-bottom:18px;"><a href="friend_trips.php?userId=' . $member['user_id'] . '" style="font-size:1.1rem; color:#007bff; text-decoration:none;">' . htmlspecialchars($member['Name']) . '</a></li>';
            }
        }
        ?>
        </ul>
        <a href="Search.php" class="btn" style="margin-top:24px;">Back to Search</a>
    </div>
    <?php require 'Component/footer.php'; ?>
</body>
</html>
