<?php
session_start();
require 'cmsql.php';

if (isset($_SESSION['user_id'])) {
  header("Location: edit1.php");
  exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  // Validate input
  if (empty($email) || empty($password)) {
    $error = "Email and password are required.";
  } else {
    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT Id, Password_hash FROM user WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
      if (password_verify($password, $row['Password_hash'])) {
        $_SESSION['user_id'] = $row['Id'];
        header("Location: edit1.php");
        exit();
      } else {
        $error = "Invalid email or password.";
      }
    } else {
      $error = "Invalid email or password.";
    }

    $stmt->close();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="stylesheet" href="signin1.css">
</head>

<body>
  <div class="signin-container">
    <div class="signin-card">
      <div class="signin-form-section">
        <div class="signin-header">
          <i class="fa-solid fa-tree"></i>
          <h1>Trip Planner</h1>
        </div>
        <h2>Sign in</h2>
        <p class="signin-subtext">Please login to continue to your account.</p>
        <?php if (!empty($error)) {
          echo '<div class="error-message" style="color:red;">' . htmlspecialchars($error) . '</div>';
        } ?>
        <form method="POST">
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
          <div class="form-remember">
            <input type="checkbox" id="rememberMe" name="rememberMe">
            <label for="rememberMe">Keep me logged in</label>
          </div>
          <button type="submit" class="signin-btn">Sign in</button>
        </form>

        <div class="signin-footer">
          Need an account?
          <a href="signup1.php"> <u>Create one</u> </a>
        </div>
      </div>
      <div class="signin-image-section"></div>
    </div>
  </div>
</body>

</html>