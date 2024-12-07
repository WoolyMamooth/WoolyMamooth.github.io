<?php
  // Connect to the database
  $db = mysqli_connect("localhost", "woolymne_datab", "wooly_admin", "woolymne_datab");

  // Check if the login form has been submitted
  if (isset($_POST['login'])) {
    // Get the form data
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Validate the form data
    if (empty($username) || empty($password)) {
      $error = "Username and password are required";
    } else {
      // Check if the username exists in the database
      $query = "SELECT * FROM users WHERE username='$username'";
      $result = mysqli_query($db, $query);
      if (mysqli_num_rows($result) == 0) {
        $error = "Username does not exist";
      } else {
        // Get the user data from the database
        $user = mysqli_fetch_assoc($result);

        // Check if the entered password is correct
        if (password_verify($password, $user['password'])) {
          // Login the user
          session_start();
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['username'] = $user['username'];
          $_SESSION['is_admin'] = $user['is_admin'];
          header("Location: user_profile.php");
        } else {
          $error = "Incorrect password";
        }
      }
    }
  }
?>

<!-- Include the stylesheet and header -->
<?php include '../navbar.html'; ?>

<!-- Display the login form -->
<form method="post" action="login.php">
  <label for="username">Username:</label>
  <input type="text" name="username" required>
  <label for="password">Password:</label>
  <input type="password" name="password" required><br>
  <input type="submit" name="login" value="Login">
  <?php if (isset($error)) { echo $error; } ?>
</form>
