<?php

  require_once 'srv/_config_admin.php';

  unset($_SESSION['access_token']);

  $gClientAdmin->revokeToken();

  session_destroy();

  header('Location: login.php');

  exit();

?>
