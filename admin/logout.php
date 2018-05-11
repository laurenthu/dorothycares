<?php

  require_once 'srv/_config_admin.php';

  unset($_SESSION['access_token']); // unset the access token

  $gClientAdmin->revokeToken(); // revoke it

  session_destroy();

  header('Location: login.php'); // redirects to login page

  exit();

?>
