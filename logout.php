<?php
  require_once "srv/config.php";
  unset($_SESSION['access_token']);
  $gClient->revokeToken();
  session_destroy();
  header('Location: login.php');
  exit();
?>
