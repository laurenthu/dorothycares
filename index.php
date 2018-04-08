<?php

  session_start();

  if (!isset($_SESSION['access_token'])) {
    header('Location: login.php');
    exit();
  } else {
    header('Location: main.php');
    exit();
  }

  //echo $_SESSION['email'];
?>
