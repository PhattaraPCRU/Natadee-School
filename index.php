<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/utility_loader.php'); ?>
<html>
    <head>
        <title>Natadee School</title>
        <style>
            body{
                overflow: hidden;
            }
            iframe{
                position: absolute;
                top: -15%;
                left: 0;
                width: 100%;
                height: 130%;
                z-index: -1;
            }
        </style>
    </head>
    <body>
    <div class="footer-wrapper">
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nav_loader.php'; ?>
        <div style="position: relative; min-height: 80vh;">
            <div class="footer-content" align="center">
                <!-- Content Here -->
            <iframe src="https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?&enablejsapi=1&autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        <?PHP include_once $_SERVER['DOCUMENT_ROOT'] . '/php/footer_loader.php'; ?>
    </div>
    </body>
</html>