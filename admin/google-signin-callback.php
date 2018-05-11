<?php
  require_once 'srv/_config_admin.php';

  if (isset($_SESSION['access_token'])) { // check if google access token exists
    $gClientAdmin->setAccessToken($_SESSION['access_token']); // set it
  } else if (isset($_GET['code'])) { // else
    $token = $gClientAdmin->fetchAccessTokenWithAuthCode($_GET['code']); // get it
    $_SESSION['access_token'] = $token; // store it's value
  } else { // else
    header('Location: ../login.php'); // redirect to login
    exit();
  }

  $oAuth = new Google_Service_Oauth2($gClientAdmin); // new instance
  $userData = $oAuth->userinfo_v2_me->get(); // get the user data

  // store the data in global variables
  $_SESSION['email'] = $userData['email'];
  $_SESSION['gender'] = $userData['gender'];
  $_SESSION['picture'] = $userData['picture'];
  $_SESSION['familyName'] = $userData['familyName'];
  $_SESSION['givenName'] = $userData['givenNme'];

  $userTest = new User($db);

  if ( $userTest->hasAdminRights($userData['email']) ) { // if user has admin rights
    include '../GoogleAPI/vendor/firebase/php-jwt/src/JWT.php'; // include json web token code
    $jwtInstance = new JWT(); // create new instance
    $payload = [
      "email"=> $_SESSION['email'],
      "sub"=> "dorothycares",
      "admin"=>true
    ];
    $_SESSION['jwt'] = $jwtInstance->encode($payload, SECRET_KEY); // create a json web token and store it in global variable

    header('Location: admin-management.php'); // redirect to admin interface
    exit();
  } else {
    header('Location: logout.php'); // logout (which redirects to login page)
    exit();
  }

  /*echo '<pre>';
  var_dump($_SESSION);
  echo '</pre>';*/

?>
