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
<?php
  $game = $_GET['game'];
  $filePath = 'swf/'.$game.'.swf';
  if (file_exists($filePath)) {
?>
<script src="https://unpkg.com/@ruffle-rs/ruffle"></script>
<body>
  
<object id="player" type="application/x-shockwave-flash" data="swf/<?php echo $game?>.swf" width="80%" height=80%>
  <param name="movie" value="swf/<?php echo $game?>.swf" />
  <param name="quality" value="high" />
  <param name="wmode" value="transparent" />
</object>
  
<?php
  } else {
?>
<script src="https://unpkg.com/@ruffle-rs/ruffle"></script>
<body>
  
<object id="player" type="application/x-shockwave-flash" data="swf/nsfw/<?php echo $game?>.swf" width="80%" height=80%>
  <param name="movie" value="swf/nsfw/<?php echo $game?>.swf" />
  <param name="quality" value="high" />
  <param name="wmode" value="transparent" />
</object>
<?php
  }
?>
</body>