<?php
  require_once "srv/_config.php";
  require_once "srv/_google-signin-client.php";

  if (isset($_SESSION['access_token'])) {

    $gClient->setAccessToken($_SESSION['access_token']);

  } else if (isset($_GET['code'])) {

    $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;

  } else {

    header('Location: '.HOME_URL.'login/');
    exit();

  }

  $oAuth = new Google_Service_Oauth2($gClient);
  $userData = $oAuth->userinfo_v2_me->get();


  $_SESSION['id'] = $userData['id'];
  $_SESSION['email'] = $userData['email'];
  //$_SESSION['gender'] = $userData['gender'];
  //$_SESSION['picture'] = $userData['picture'];
  //$_SESSION['familyName'] = $userData['familyName'];
  //$_SESSION['givenName'] = $userData['givenNme'];

  $userTest = new User($db);

  if ( $userTest->hasAuthorizedAccess($userData['email']) ) { // if user can access

    $u = new User($db);

    if( !$u->checkGoogleIdUser($userData['email']) ) {
      $u->updateGoogleIdUser($userData['email'],$userData['id']);
    }
    $u->addUserLog($userData['email']);
    $u->updateRandomSaltdUser($userData['email']);
    $u->updatePasswordUser($userData['email']);

    $_SESSION['token'] = $u->getRandomSaltdUser($userData['email']);

    header('Location: '.HOME_URL);
    exit();

  } else {

    header('Location: '.HOME_URL.'logout/');
    exit();

  }

  /*echo '<hr>';
  echo '<pre>';
  print_r($userData);
  echo '<hr>';
  var_dump($_SESSION);
  echo '</pre>';*/

?>
