<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Family Account</title>
  <link rel="stylesheet" href="css/Suggestion.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <?php require 'Component/navbar.php';

  ?>

  <main>
    <section class="content 1">
      <h1>Search Accounts</h1>
      <div class="search-bar">
        <form method="GET" action="">
          <input type="text" name="Search" id="familySearch" placeholder="Search Profile Accounts..." />
          <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
      </div>
      <div class="family-list">
        <?php
        require 'cmsql.php';
        $search = isset($_GET['Search']) ? trim($_GET['Search']) : '';
        if ($search !== '') {
          $search = mysqli_real_escape_string($conn, $search);
          $query = "SELECT * FROM user_info WHERE Name LIKE '%$search%'";
        } else {
          $query = "SELECT * FROM user_info";
        }
        $result = mysqli_query($conn, $query);
        if (!$result) {
          echo "Error: " . mysqli_error($conn);
          exit();
        }
        while ($user_info = mysqli_fetch_assoc($result)) {
          echo "<a href=\"#\" class=\"family-card\">";
          echo "<img src=\"https://picsum.photos/60?random={$user_info['userId']}\" alt=\"{$user_info['Name']}\" />";
          echo "<div class=\"info\">";
          echo "<p class=\"name\">{$user_info['Name']}</p>";
          if ($user_info['Travel_level'] === 'Bronze') {
            $badge_class = '🥉';
          } elseif ($user_info['Travel_level'] === 'Silver') {
            $badge_class = '🥈';
          } else {
            $badge_class = '🥇';
          }
          echo "<p class=\"members\">Travel Level: {$user_info['Travel_level']}  {$badge_class}</p>";
          echo "</div>";
          echo "</a>";
        }
        ?>
      </div>
    </section>
  </main>
</body>

</html>