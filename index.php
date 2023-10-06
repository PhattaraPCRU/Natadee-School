<?php
include('php/utility_loader.php');
?>
<html>
<head>
  <title>Natadee-School</title>
  <style>
    body{
      background-image: url("/res/img/chadchat_yowaimo.jpg");
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position-y: 20%;
    }
  </style>
</head>
<body>
<div class="footer-wrapper">
  <?php include_once 'php/nav_loader.php'; ?>
  <div class="footer-content" align="center">
    <!-- Content Here -->
  </div>
  <?PHP include_once 'php/footer_loader.php'; ?>
</div>
<?php include_once 'php/post_loader.php'; ?>
</body>
</html>