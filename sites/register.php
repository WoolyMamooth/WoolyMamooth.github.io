<?php
  // Connect to the database
  $db = mysqli_connect("localhost", "woolymne_datab", "wooly_admin", "woolymne_datab");

  // Check if the registration form has been submitted
  if (isset($_POST['register'])) {
    // Get the form data
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $password_confirm = mysqli_real_escape_string($db, $_POST['password_confirm']);

    // Validate the form data
    if (empty($username) || empty($password) || empty($password_confirm)) {
      $error = "All fields are required";
    } else if ($password != $password_confirm) {
      $error = "Passwords do not match";
    } else {
      // Check if the username is already taken
      $query = "SELECT * FROM users WHERE username='$username'";
      $result = mysqli_query($db, $query);
      if (mysqli_num_rows($result) > 0) {
        $error = "Username is already taken";
      } else {
        
        if($_POST['whitelist_pass']=="feketebebimopsz"){
        
          // Encrypt the password
          $password = password_hash($password, PASSWORD_DEFAULT);

          // Insert the new user into the database
          $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
          mysqli_query($db, $query);
          header("Location: login.php");
        }else{
        	$error = "You aren't permitted to make an account.";
        }
      }
    }
  }
?>

<!-- Include the stylesheet and header -->
<?php include '../navbar.html'; ?>

<!-- Display the registration form -->
<form method="post" action="register.php">
  <label for="username">Username:</label>
  <input type="text" name="username" required>
  <label for="password">Password:</label>
  <input type="password" name="password" required>
  <label for="password_confirm">Confirm Password:</label>
  <input type="password" name="password_confirm" required><br>
  <label for="whitelist_pass">Whitelist password:</label>
  <input type="whitelist_pass" name="whitelist_pass" required>
  <input type="submit" name="register" value="Register">
  <?php if (isset($error)) { echo $error; } ?>
</form>
