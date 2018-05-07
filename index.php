<?php

  require_once "srv/_config.php";

  if (!isset($_SESSION['access_token'])) {
    header('Location: '.HOME_URL.'login.php');
    exit();
  } else {
    header('Location: '.HOME_URL.'main.php');
    exit();
  }

  //echo $_SESSION['email'];
?>
