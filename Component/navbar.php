
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./css/navbar.css">
</head>
<body>
<header class="header">
    <a href="home1.php">
        <div class="header-brand">
            <i class="fa-solid fa-tree"></i>
            <h1 class="header-title">Trip Planner</h1>
        </div>
    </a>
    <nav class="header-nav">
        <ul class="nav-list">
            <li><a href="Suggestion.php" class="nav-link">Explore</a></li>
            <li><a href="create_trip.php" class="nav-link">Trips</a></li>
            <li><a href="logout.php" class="nav-link">Log out</a></li>
            <li><a href="notification1.php"><i class="fa-solid fa-bell nav-bell"></i></a></li>
            <form method="GET" action="Search.php">
                <input type="text" name="Search" placeholder="Search Profile" />
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <li><a href="edit1.php"><img src="images/Image 1.png" alt="Profile" class="nav-profile"></a></li>
        </ul>
    </nav>
</header>
</body>
</html>