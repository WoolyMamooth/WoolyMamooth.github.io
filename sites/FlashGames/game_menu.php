<?php
  // Start the session
  session_start();

  // Check if the user is logged in
  if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../login.php");
  }
?>
<?php include '../../navbar.html'; ?>
<form action="game.php" method="get" class="gamemenu">
  <div class="button-grid">
  <?php
  // open the "swf" folder
  $dir = opendir("swf");
    
    
      // array to store buttons grouped by starting letter
    $buttonsByLetter = array();

    // read the files in the folder
    while (($file = readdir($dir)) !== false) {
      // only add a button for .swf files
      if (substr($file, -4) == ".swf") {
        $gameName = substr($file, 0, -4);
        $startingLetter = strtoupper($gameName[0]);

        // add the button to the array grouped by starting letter
        if (!array_key_exists($startingLetter, $buttonsByLetter)) {
          $buttonsByLetter[$startingLetter] = array();
        }
        $buttonsByLetter[$startingLetter][] = $gameName;
      }
    }
    // close the folder
    closedir($dir);
    
    // sort the buttons by starting letter
    ksort($buttonsByLetter);
    
    // generate the buttons in alphabetical order
    foreach ($buttonsByLetter as $startingLetter => $buttons) {
      echo '<div>';
      foreach ($buttons as $gameName) {
        echo '<input type="submit" name="game" value="' . $gameName . '" class="gamebutton" />';
      }
      echo '</div>';
    }
  
  if($_SESSION['is_admin']){
     echo'<div>';
      // open the "swf" folder
      $dir = opendir("swf/nsfw");


      echo '<br><a>NSFW</a><br>';
      // read the files in the folder
      while (($file = readdir($dir)) !== false) {
        // only add a button for .swf files
        if (substr($file, -4) == ".swf") {
          $gameName = substr($file, 0, -4);
          echo '<input type="submit" name="game" value="' . $gameName . '" class="gamebutton"/>';
        }
      }
     echo'</div>';
  }

  // close the folder
  closedir($dir);
  ?>
  </div>
</form>
