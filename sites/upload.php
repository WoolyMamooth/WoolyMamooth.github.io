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

  // Check if the form has been submitted
  if (isset($_POST['submit'])) {
    // Check if a file has been selected for upload
    if (isset($_FILES['file'])) {
      // Get the file information
      $file = $_FILES['file'];
      $file_name = $file['name'];
      $file_size = $file['size'];
      $file_tmp = $file['tmp_name'];
      $file_type = $file['type'];

      // Set the maximum file size (in bytes)
      $max_size = 1000000000; // 1GB

      // Check if the file is too large
      if ($file_size > $max_size) {
        $error = "File is too large. Maximum file size is 1GB.";
      } else {
        // Set the target directory for the uploaded file
        if (substr($file_name, -4) == ".swf") {
          $target_dir = "FlashGames/swf/";
          // Set the target path for the uploaded file
          $target_path = $target_dir . $file_name;
        }else if(isset($_POST['ishelpme'])){
          $target_dir = "helpme/";
          $target_path = $target_dir . $file_name;
        } else {
          $target_dir = "../uploads/";
          // Set the target path for the uploaded file
          $target_path = $target_dir .$_SESSION['username'].'-'. $file_name;
        }
          // Check if the file already exists in the target directory
          if (file_exists($target_path)) {
            $error = "File already exists. Please choose a different file.";
          } else {
            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($file_tmp, $target_path)) {
          // File was successfully uploaded
          $message = "File was successfully uploaded.";
          } else {
          // File was not successfully uploaded
          $error = "There was an error uploading the file.";
          }
    	  }
      }
    } else {
      // No file was selected for upload
      $error = "No file was selected.";
    }
  }
?>
<?php include '../navbar.html'; ?>
<!-- Display the upload form -->
<form method="post" enctype="multipart/form-data">
    <label for="file">Choose a file to upload:</label>
    <input type="file" name="file" required>
    <label for="ishelpme">Helpme</label>
    <input type="checkbox" name="ishelpme">
    <label for="submit">Upload</label>
    <input type="submit" name="submit" value="Upload">
</form>
<!-- Display any messages or errors -->
<?php if (isset($message)) { echo $message; } ?>
<?php if (isset($error)) { echo $error; } ?>