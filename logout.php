<?php

  require_once "srv/_config.php";
  require_once "srv/_google-signin-client.php";

  (new User($db))->deleteRandomSaltdUser($_SESSION['email']);

  unset($_SESSION['access_token']);

  $gClient->revokeToken();

  session_destroy();

  header('Location: '.HOME_URL);

  exit();

?>
