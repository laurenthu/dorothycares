<?php

  session_start();

  if (!isset($_SESSION['access_token'])) {
    header('Location: login.php');
    exit();
  } else {
    header('Location: main.php');
    exit();
  }
?>
<!-- <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      echo $_SESSION['email'];
    ?>
  </body>
</html> -->
