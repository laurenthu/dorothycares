<?php

  require_once "srv/_config.php";
  require_once "srv/_google-signin-client.php";

  (new User($db))->deleteRandomSaltdUser($_SESSION['email']);

  unset($_SESSION['access_token']);
  $_SESSION = null;

  $gClient->revokeToken();

  session_destroy();

  //var_dump($_SESSION);

  header('Location: '.HOME_URL);

  exit();

?>
