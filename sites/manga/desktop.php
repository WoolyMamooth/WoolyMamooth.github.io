<html>
 <?php include_once '../../navbar.html'; ?>
<head>
  <style>
    body {
      background-color: #333333;
      color: #FFFFFF;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
    }
    .folder-list {
      list-style: none;
      padding: 0;
    }
    .folder-list li {
      margin-bottom: 10px;
    }
    .chapter-list {
      list-style: none;
      padding: 0;
    }
    .chapter-list li {
      margin-bottom: 10px;
    }
    .chapter-images {
      margin-left: 20px;
    }
    .chapter-images img {
      display: block;
      margin-bottom: 0px;
      max-width: 100%;
    }
    .navigation {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }
    .navigation button {
      padding: 5px 10px;
      background-color: #666666;
      color: #FFFFFF;
      border: none;
      cursor: pointer;
    }
  </style>
</head>
<body>
<div class="container">
<?php

$baseDir = './manga';

function naturalSort($a, $b) {
  return strnatcmp($a, $b);
}

if (isset($_GET['manga'])) {
  $mangaDir = $baseDir . '/' . $_GET['manga'];

  if (isset($_GET['chapter'])) {
    $chapterDir = $mangaDir . '/' . $_GET['chapter'];
    $images = glob($chapterDir . '/*.{jpg,png,gif}', GLOB_BRACE);
    usort($images, 'naturalSort');
    ?>

    <h2><?php echo $_GET['manga']; ?> - <?php echo $_GET['chapter']; ?></h2>

    <div class="navigation">
      <?php
      $prevChapter = '';
      $nextChapter = '';
      $chapters = array_filter(glob($mangaDir . '/*', GLOB_ONLYDIR), 'is_dir');
      usort($chapters, 'naturalSort');
      $currentChapterIndex = array_search($_GET['chapter'], array_map('basename', $chapters));
      if ($currentChapterIndex > 0) {
        $prevChapter = $chapters[$currentChapterIndex - 1];
      }
      if ($currentChapterIndex < count($chapters) - 1) {
        $nextChapter = $chapters[$currentChapterIndex + 1];
      }
      ?>
      <?php if (!empty($prevChapter)) : ?>
        <button onclick="location.href='?manga=<?php echo $_GET['manga']; ?>&chapter=<?php echo basename($prevChapter); ?>'">Previous Chapter</button>
      <?php endif; ?>
      <button onclick="location.href='desktop.php'">MENU</button>
      <?php if (!empty($nextChapter)) : ?>
        <button onclick="location.href='?manga=<?php echo $_GET['manga']; ?>&chapter=<?php echo basename($nextChapter); ?>'">Next Chapter</button>
      <?php endif; ?>
    </div>

    <div class="chapter-images">
      <?php
      foreach ($images as $image) {
        echo '<img src="' . $image . '" alt="Chapter Image" />';
      }
      ?>
    </div>

    <div class="navigation">
      <?php if (!empty($prevChapter)) : ?>
        <button onclick="location.href='?manga=<?php echo $_GET['manga']; ?>&chapter=<?php echo basename($prevChapter); ?>'">Previous Chapter</button>
      <?php endif; ?>
      <button onclick="location.href='desktop.php'">MENU</button>
      <?php if (!empty($nextChapter)) : ?>
        <button onclick="location.href='?manga=<?php echo $_GET['manga']; ?>&chapter=<?php echo basename($nextChapter); ?>'">Next Chapter</button>
      <?php endif; ?>
    </div>

    <?php
  } else {
    $chapters = array_filter(glob($mangaDir . '/*', GLOB_ONLYDIR), 'is_dir');
    usort($chapters, 'naturalSort');
    ?>

    <h2><?php echo $_GET['manga']; ?></h2>

    <ul class="chapter-list">
      <?php
      foreach ($chapters as $chapter) {
        $chapterName = basename($chapter);
        echo '<li><a href="?manga=' . $_GET['manga'] . '&chapter=' . $chapterName . '">' . $chapterName . '</a></li>';
      }
      ?>
    </ul>

    <?php
  }
} else {
  $mangas = array_filter(glob($baseDir . '/*'), 'is_dir');
  ?>

  <h2>Manga List</h2>

  <ul class="folder-list">
    <?php
    foreach ($mangas as $manga) {
      $mangaName = basename($manga);
      echo '<li><a href="?manga=' . $mangaName . '">' . $mangaName . '</a></li>';
    }
    ?>
  </ul>

  <?php
}

?>
</div>
</body>
</html>
