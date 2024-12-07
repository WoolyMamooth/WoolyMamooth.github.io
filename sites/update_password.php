<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  // Redirect to the login page or display an error message
  // if the user is not logged in
  header("Location: login.php");
  exit;
}

// Retrieve the user ID from the session
$user_id = $_SESSION['user_id'];

// Retrieve the form data
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Perform any necessary validations on the form data
// ...

// Connect to the database
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve the current password from the database
$sql = "SELECT password FROM user WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $stored_password = $row['password'];

  // Verify the current password
  if (password_verify($current_password, $stored_password)) {
    // Generate a new password hash
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $update_sql = "UPDATE user SET password = '$new_password_hash' WHERE id = '$user_id'";
    if ($conn->query($update_sql) === TRUE) {
      // Password updated successfully
      echo "Password updated successfully.";
    } else {
      // Error updating password
      echo "Error updating password: " . $conn->error;
    }
  } else {
    // Current password is incorrect
    echo "Incorrect current password.";
  }
} else {
  // User not found in the database
  echo "User not found.";
}

$conn->close();
?>
