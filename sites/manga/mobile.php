<html>
<?php include_once '../../navbar.html'; ?>

<head>
    <style>
        body {
            background-color: #333333;
            color: #FFFFFF;
            font-size: 30px;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }

        .chapter-images {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-left: -20px;
            margin-right: -20px;
        }

        .chapter-images img {
            display: block;
            margin-bottom: -1px;
            width: 100vw;
            height: auto;
            padding: 0;
        }

        @media only screen and (max-width: 768px) {
            .chapter-images {
                margin-left: 0;
                margin-right: 0;
            }
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .navigation button {
            padding: 1px 11px;
            font-size: 29px;
            background-color: #666666;
            color: #FFFFFF;
            border: none;
            cursor: pointer;
        }

        /* Hide the scrollbar for webkit-based browsers */
        ::-webkit-scrollbar {
            width: 0;
            background: transparent;
        }

        #fullscreenButton {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php

        $baseDir = './manga';

        function naturalSort($a, $b)
        {
            return strnatcmp($a, $b);
        }

        function isMobileDevice()
        {
            return preg_match("/Mobile|Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|Windows Phone/i", $_SERVER['HTTP_USER_AGENT']);
        }

        if (isset($_GET['manga'])) {
            $mangaDir = $baseDir . '/' . $_GET['manga'];

            if (isset($_GET['chapter'])) {
                $chapterDir = $mangaDir . '/' . $_GET['chapter'];
                $images = glob($chapterDir . '/*.{jpg,png,gif}', GLOB_BRACE);
                usort($images, 'naturalSort');
        ?>

                <h2><?php echo $_GET['manga']; ?> - <?php echo $_GET['chapter']; ?></h2>
                
                <?php if (isset($_GET['fullscreen']) && $_GET['fullscreen'] == 'true') {
                        echo '<script>
                            go_fullscreen;
                        </script>';
                        $fullscreen='true';
                    }else {
                        $fullscreen='false';
                    }
                ?>

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
                    <button onclick="location.href='mobile.php'">MENU</button>
                    <?php if (!empty($nextChapter)) : ?>
                        <button onclick="location.href='?manga=<?php echo $_GET['manga']; ?>&chapter=<?php echo basename($nextChapter);?>&fullscreen=true'">Next Chapter</button>
                    <?php endif; ?>
                    <button id="fullscreenButton">Fullscreen</button>
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
                    <button onclick="location.href='mobile.php'">MENU</button>
                    <?php if (!empty($nextChapter)) : ?>
                        <button onclick="location.href='?manga=<?php echo $_GET['manga']; ?>&chapter=<?php echo basename($nextChapter);?>&fullscreen=true'">Next Chapter</button>
                    <?php endif; ?>
                </div>

                <script>
                    var fullscreenButton = document.getElementById('fullscreenButton');

                    // Check if the Fullscreen API is supported
                    if (document.documentElement.requestFullscreen || document.documentElement.mozRequestFullScreen || document.documentElement.webkitRequestFullscreen || document.documentElement.msRequestFullscreen) {

                        // Add a click event listener to the button
                        fullscreenButton.addEventListener('click', go_fullscreen);

                        function go_fullscreen() {
                            if (document.documentElement.requestFullscreen) {
                                document.documentElement.requestFullscreen();
                            } else if (document.documentElement.mozRequestFullScreen) { // Firefox
                                document.documentElement.mozRequestFullScreen();
                            } else if (document.documentElement.webkitRequestFullscreen) { // Chrome, Safari, and Opera
                                document.documentElement.webkitRequestFullscreen();
                            } else if (document.documentElement.msRequestFullscreen) { // IE/Edge
                                document.documentElement.msRequestFullscreen();
                            }
                            <?php $fullscreen='true'; ?>
                        }


                        // Add a fullscreenchange event listener to update the visibility of the button
                        document.addEventListener('fullscreenchange', handleFullscreenChange);
                        document.addEventListener('mozfullscreenchange', handleFullscreenChange); // Firefox
                        document.addEventListener('webkitfullscreenchange', handleFullscreenChange); // Chrome, Safari, and Opera
                        document.addEventListener('msfullscreenchange', handleFullscreenChange); // IE/Edge

                        function handleFullscreenChange() {
                            if (document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement) {
                                fullscreenButton.style.display = 'none'; // Hide the fullscreen button
                            } else {
                                fullscreenButton.style.display = 'block'; // Show the fullscreen button
                            }
                        }
                    } else {
                        fullscreenButton.style.display = 'none'; // Hide the fullscreen button if the API is not supported
                    }
                </script>

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
                        echo '<li><a href="?manga=' . $_GET['manga'] . '&chapter=' . $chapterName . '">Chapter - ' . $chapterName . '</a></li>';
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