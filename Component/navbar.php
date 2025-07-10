
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
    <div style="display: flex; flex-direction: row;">
        <button class="hamburger" id="hamburger">
            <i class="fa-solid fa-bars"></i>
        </button>
    <nav class="header-nav" id="navbar">
        <ul class="nav-list">
            <li><a href="Suggestion.php" class="nav-link">Explore</a></li>
            <li><a href="create_trip.php" class="nav-link">Trips</a></li>
            <li><a href="logout.php" class="nav-link">Log out</a></li>
            <li><a href="notification1.php"><i class="fa-solid fa-bell nav-bell"></i></a></li>
            <form method="GET" action="Search.php">
                <input type="text" name="Search" placeholder="Search Profile" />
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </ul>
    </nav>
    <a href="edit1.php"><img src="images/Image 1.png" alt="Profile" class="nav-profile"></a>
    </div>
</header>
<script>
    const hamburger = document.getElementById("hamburger");
    const navbar = document.getElementById("navbar");

    hamburger.addEventListener("click", () => {
        navbar.classList.toggle("active");
    });
</script>
</body>
</html>