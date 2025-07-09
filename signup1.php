<?php
include 'cmsql.php';

session_start();

if (!empty($_GET['name']) && !empty($_GET['email']) && !empty($_GET['password'])) {
  $name = htmlspecialchars($_GET['name']);
  $email = htmlspecialchars($_GET['email']);
  $password = htmlspecialchars($_GET['password']);

  $password = password_hash($password, PASSWORD_DEFAULT);

  $sql = "INSERT INTO user (Email, Password_hash) VALUES ('$email', '$password')";
  $qur = mysqli_query($conn, $sql);
  if (!$qur){
    echo "Error: " . mysqli_error($conn);
  } else {
    $userId = mysqli_insert_id($conn);
    $sql = "INSERT INTO user_info (userId, Name) VALUES ('$userId', '$name')";
    $qur = mysqli_query($conn, $sql);
    if (!$qur) {
      echo "Error: " . mysqli_error($conn);
    } else {
      $_SESSION['user_id'] = $userId;
      header("Location: edit1.php");
      exit();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="stylesheet" href="signup1.css">
</head>

<body>
  <div class="signup-container">
    <div class="signup-card">
      <div class="signup-form-section">
        <a href="home1.php"><div class="signup-header">
          <i class="fa-solid fa-tree"></i>
          <h1>Trip Planner</h1>
        </div></a>
        <h2>Sign up</h2>
        <p class="signup-subtext">Sign up to enjoy the feature of Revolutie</p>
        <form>
          <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="name">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <div class="password-wrapper">
              <input type="password" id="password" name="password">
            </div>
          </div>
          <button type="submit" class="signup-btn">Sign up</button>
        </form>
        <div class="signup-footer">
          Already have an account? <a href="signin1.php"><u>Sign in</u></a>
        </div>
      </div>
      <div class="signup-image-section"></div>
    </div>
  </div>
</body>

</html>