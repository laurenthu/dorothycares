<?php
  require_once 'srv/_config_admin.php';

  if (isset($_SESSION['access_token'])) {
    $gClientAdmin->setAccessToken($_SESSION['access_token']);
  } else if (isset($_GET['code'])) {
    $token = $gClientAdmin->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;
  } else {
    header('Location: ../login.php');
    exit();
  }

  $oAuth = new Google_Service_Oauth2($gClientAdmin);
  $userData = $oAuth->userinfo_v2_me->get();


  $_SESSION['email'] = $userData['email'];
  $_SESSION['gender'] = $userData['gender'];
  $_SESSION['picture'] = $userData['picture'];
  $_SESSION['familyName'] = $userData['familyName'];
  $_SESSION['givenName'] = $userData['givenNme'];

  $userTest = new User($db);

  if ( $userTest->hasAdminRights($userData['email']) ) { // if user can access
    header('Location: admin.php');
    exit();
  } else {
    header('Location: logout.php');
    exit();
  }

  /*echo '<pre>';
  var_dump($_SESSION);
  echo '</pre>';*/

?>
