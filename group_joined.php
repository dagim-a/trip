<?php
// group_joined.php
require_once 'cmsql.php';
$groupId = isset($_GET['groupId']) ? intval($_GET['groupId']) : 0;
if ($groupId) {
    $stmt = $conn->prepare('SELECT Name FROM user_info WHERE userId = ?');
    $stmt->bind_param('i', $groupId);
    $stmt->execute();
    $result = $stmt->get_result();
    $group = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Group Joined</title>
    <link rel="stylesheet" href="css/Search.css">
</head>
<body>
    <?php require 'Component/navbar.php'; ?>
    <div class="main-container" style="text-align:center; margin-top:60px;">
        <h2>Group Joined!</h2>
        <?php if (!empty($group['Name'])): ?>
            <p>You have successfully joined <strong><?php echo htmlspecialchars($group['Name']); ?></strong>'s group.</p>
        <?php else: ?>
            <p>Group joined successfully.</p>
        <?php endif; ?>
        <a href="Search.php" class="btn" style="margin-top:24px;">Back to Search</a>
    </div>
    <?php require 'Component/footer.php'; ?>
</body>
</html>
