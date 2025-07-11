<?php
// friend_added.php
require_once 'cmsql.php';
$userId = isset($_GET['userId']) ? intval($_GET['userId']) : 0;
if ($userId) {
    $stmt = $conn->prepare('SELECT Name FROM user_info WHERE userId = ?');
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
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
    <title>Friend Added</title>
    <link rel="stylesheet" href="css/Search.css">
</head>
<body>
    <?php require 'Component/navbar.php'; ?>
    <div class="main-container" style="text-align:center; margin-top:60px;">
        <h2>Friend Added!</h2>
        <?php if (!empty($user['Name'])): ?>
            <p>You have successfully added <strong><?php echo htmlspecialchars($user['Name']); ?></strong> as a friend.</p>
        <?php else: ?>
            <p>Friend added successfully.</p>
        <?php endif; ?>
        <a href="Search.php" class="btn" style="margin-top:24px;">Back to Search</a>
    </div>
    <?php require 'Component/footer.php'; ?>
</body>
</html>
