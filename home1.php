<?php
require 'cmsql.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="css/home1.css">
</head>

<body>
    <nav class="main-nav">
        <a href="home1.php">
            <div class="brand">
                <i class="fa-solid fa-tree"></i>
                <h1>Trip Planner</h1>
            </div>
        </a>
        <ul>
            <li><a href="home1.php">Home</a></li>
            <li><a href="signup1.php">Sign Up</a></li>
            <li><a href="signin1.php">Login</a></li>
        </ul>
    </nav>
    <div class="hero">
        <div class="hero-content">
            <p>Plan, personalize, and track your perfect trip</p>
            <p><strong>From custom itineraries and <br> budget tools to shared plan...</strong></p>
        </div>
        <div class="hero-search">
            <input type="text" placeholder="Explore the world with ease">
            <button>Search</button>
        </div>
    </div>
    <section class="section">
        <h2>Unleash Your Wanderlust</h2>
        <p>Embark on a journey like no other with our comprehensive travel <br> planner. Discover destinations, curate your perfect itinerary...</p>
        <div class="features">
            <div class="feature-card">
                <div class="icon-bg" style="background-color: #aed9a6;">
                    <img src="images/Image 2.png" alt="Graph Icon">
                </div>
                <h3>Reach New Heights</h3>
                <p>Elevate your travel <br> experience with our easy- <br>to-use tools and persona...</p>
            </div>
            <div class="feature-card">
                <div class="icon-bg" style="background-color: #f2a7a7;">
                    <img src="images/Image 3.png" alt="Map Icon">
                </div>
                <h3>Unlock Endless Possibilit...</h3>
                <p>Discover a world of <br> experiences with our <br> intuitive travel planner...</p>
            </div>
            <div class="feature-card">
                <div class="icon-bg" style="background-color: #f2d379;">
                    <img src="images/Image 4.png" alt="Pin Icon">
                </div>
                <h3>Embark on Your Journey</h3>
                <p>Explore new horizons and <br> create lasting memories <br> with our comprehensive tra...</p>
            </div>
        </div>
    </section>
    <div class="confidence">
        <h2>Plan with Confidence</h2>
        <p>With our powerful travel planner, you can create custom <br> itineraries, track your budget, and manage every detail of...</p>
        <button>Get Started</button>
    </div>

    <button class="hamburger" aria-label="Open menu">&#9776;</button>

    <nav class="mobile-bottom-nav">
        <a href="#" class="mobile-nav-item">
            <i class="fa-solid fa-house"></i>
            <span class="mobile-nav-label">Home</span>
        </a>
        <a href="signup1.php" class="mobile-nav-item">
            <i class="fa-solid fa-user"></i>
            <span class="mobile-nav-label">Sign up</span>
        </a>
        <a href="signin1.php" class="mobile-nav-item">
            <i class="fa-solid fa-user-plus"></i>
            <span class="mobile-nav-label">Login</span>
        </a>
    </nav>
    <?php require 'Components/footer.php'; ?>
</body>

</html>