<?php
  // Start the session
  session_start();

  // Check if the user is logged in
  if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
  }

  // Get the username from the session
  $username = $_SESSION['username'];
?>

<?php include '../navbar.html'; ?>

<h1>Downloads</h1>

<p>Here you can download all the files that have been uploaded to the site.</p>

<ul>
  <?php
    // Open the "uploads" directory
    $dir = opendir("../uploads");

    // Read all the files in the directory
    while (($file = readdir($dir)) !== false) {
      // Check if the file is not "." or ".." (current or parent directory)
      if ($file != "." && $file != "..") {
        // Print a list item with a link to the file
        echo "<li><a href='../uploads/$file' download>$file</a></li>";
      }
    }

    // Close the directory
    closedir($dir);
  ?>
</ul>