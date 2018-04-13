<?php

  require_once "srv/_config.php";

  if (!isset($_SESSION['access_token'])) {
    header('Location: '.HOME_URL.'login/');
    exit();
  } else {
    header('Location: '.HOME_URL.'app/');
    exit();
  }

  //echo $_SESSION['email'];
?>
