<?php
  	session_start();
	if (!isset($_SESSION['user_id'])) {
    	header("Location: login.php");
  	}
?>
<?php include '../navbar.html'; ?>
<html>
  <head>
      <title>User Profile</title>
  </head>
  <body>
      <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
      <div>
        <a href="?modify">
          Modify password
        </a>
        <?php
        if(isset($_GET["modify"])){?>
          <form action="update_password.php" method="POST">
            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" required><br>

            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required><br>

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" name="confirm_password" required><br>

            <input type="submit" value="Update Password">
          </form>
        <?php
        }
        ?>
      </div>
  </body>
</html>