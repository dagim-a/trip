<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Trips</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="js/script.js"></script>
</head>
<body>
  <header class="topbar">
    <div class="logo">
  <i class="fa-solid fa-tree"></i>
  Trip Planner
</div>

    <nav class="navbar">
      <ul class="nav-links">
        <li><a href="#">Home</a></li>
        <li><a class="active" href="#">Trips</a></li>
        <li><a href="#">Suggestion </a></li>
        <li><a href="#">Sign In</a></li>
      </ul>
      <input type="text" id="searchInput" placeholder="Search trips..." />  
    </nav>
  </header>

  <main>
      <section class="content">
    <div class="section-header">
     <h1>Suggested Trips</h1>
    </div>
        <?php
session_start();
require 'cmsql.php';

// Fetch all trips (optionally exclude current user's trips)
$current_user_id = $_SESSION['user_id'] ?? 0;
$sql = "SELECT t.*, u.Email AS user_email FROM Trip t JOIN user u ON t.userId = u.Id WHERE t.userId != $current_user_id";
$result = mysqli_query($conn, $sql);
?>

<ul class="trip-list">
  <?php if ($result && mysqli_num_rows($result) > 0): ?>
    <?php while ($trip = mysqli_fetch_assoc($result)): ?>
      <li class="trip-item" data-name="<?php echo htmlspecialchars($trip['Trip_name']); ?>">
        <div class="trip-info">
          <h2><?php echo htmlspecialchars($trip['Trip_name']); ?></h2>
          <p><small><?php echo htmlspecialchars($trip['Start_date']) . " – " . htmlspecialchars($trip['End_date']); ?></small></p>
          <p>Available Number of Travelers: <?php echo htmlspecialchars($trip['Number_of_Travelers']); ?></p>
          <form action="book_trip.php" method="POST">
            <input type="hidden" name="userId" value="<?php echo $current_user_id; ?>">
            <input type="hidden" name="tripId" value="<?php echo $trip['Id']; ?>"> 
            <button class="book-btn" type="submit">Book Now</button>
          </form>
        </div>
        <img src="<?php echo htmlspecialchars($trip['img'] ?? 'images/default.png'); ?>" alt="<?php echo htmlspecialchars($trip['Trip_name']); ?>" />
      </li>
    <?php endwhile; ?>
  <?php else: ?>
    <li>No suggestion at this time, sorry.</li>
  <?php endif; ?>
</ul>
    </section>
  </main>
</body>
</html>


