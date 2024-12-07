<html>
    <head>
  <title>helpme</title>
      <link rel="icon" type="image/x-icon" href="/logo1.ico">
      <style>
        body{
        background-color: rgb(74, 74, 74);
        color: white;
        margin: 0px;
        padding: 0px;
        }
        a:link, a:visited, a:active{
   		color: white;
        font-size: 24px;
		}

        .container {
          display: flex;
          align-items: center;
        }

        .text {
          flex: 1;
          padding-left: 20px;
        }
      </style>
    </head>
    <body>
      <div class="container">
       <ul>
        <?php
          // Open the "uploads" directory
          $dir = opendir("../sites/helpme");

          // Read all the files in the directory
          while (($file = readdir($dir)) !== false) {
            // Check if the file is not "." or ".." (current or parent directory)
            if ($file != "." && $file != "..") {
              // Print a list item with a link to the file
              echo "<li><a href='../sites/helpme/$file' target='_blank'>$file</a></li>";
            }
          }

          // Close the directory
          closedir($dir);
        ?>
      </ul>
  	</div>
</body>
</html>