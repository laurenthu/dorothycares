<?php

// include config file
require_once '../srv/_config.php';

$json = []; // create en empty array
header('Access-Control-Allow-Origin: *'); // to allow any resource to access the resources
header('Content-type: application/json'); // to indicate the  type of the resource

if(!isset($_GET['emailUser']) || !isset($_GET['tokenUser'])) {
  // we check if the email and the token exist
  // if not, we store the error, we send it back and we kill he script

  $json['request']['status'] = 'error';
  $json['request']['message'] = 'Sorry you can\'t access to this page without the right parameters';
  echo json_encode($json);
  die(); // we kill the script

} else {
  // if values exist, we check if they're valid and we clear them

  $email = filter_var($_GET['emailUser'], FILTER_SANITIZE_EMAIL); // Remove all characters except letters, digits and !#$%&'*+-=?^_`{|}~@.[].
  $token = filter_var($_GET['tokenUser'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); // remove all characters that have a numerical value >127.
  $type = filter_var($_GET['type'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); // remove all characters that have a numerical value >127.

}

if( !(new User($db))->checkPassworduser($email,$token) ) {
  // we check if the password of the user is valid thanks to his email and his token
  // if not, we store the error, we send it back and we kill he script

  $json['request']['status'] = 'error';
  $json['request']['message'] = 'Sorry you can\'t access to this page. Your token is invalid.';
  echo json_encode($json);
  die(); // we kill the script

} else {
  // if all the data are valid, we check what kind of data we request

  if ($type == 'startupList') {

    $json['request']['status'] = 'success';
    $json['request']['message'] = 'Congrats. You have all the requested information.';
    $json['response'] = (new Startup($db))->getStartupList(); // we store the startup list
    echo json_encode($json); // we return all the information in json

  } elseif ($type == 'startupCount') {

    $json['request']['status'] = 'success';
    $json['request']['message'] = 'Congrats. You have all the requested information.';
    $json['response'] = (new Startup($db))->getStartupCount(); // we store the startup count
    echo json_encode($json); // we return all the information in json

  } elseif ($type == 'startupMember') {

    if ( !isset($_GET['id']) ) {
      // if we don't receive any startup ID
      // we store the error, we send it back and we kill he script

      $json['request']['status'] = 'error';
      $json['request']['message'] = 'Sorry you can\'t access to this page. A paramater is missing.';
      echo json_encode($json); // we return all the information in json
      die(); // we kill the script

    } else {

      $id = filter_var($_GET['id'], FILTER_VALIDATE_INT); // we check if the ID is valid
      $typeUser = filter_var($_GET['typeUser'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); // remove all characters that have a numerical value >127.

      if ($id == false || $typeUser == false) {
        // if ID or the user type are not valid entries
        // we store the error, we send it back and we kill he script

        $json['request']['status'] = 'error';
        $json['request']['message'] = 'Sorry you can\'t access to this page. A paramater was invalid.';
        echo json_encode($json); // we return all the information in json
        die(); // we kill the script

      } else {

        $json['request']['status'] = 'success';
        $json['request']['message'] = 'Congrats. You have all the requested information.';

        if ($typeUser == 'all') {
          $json['response']['learner'] = (new Startup($db))->getStartupMemberList($id,'learner'); // we store the learner list
          $json['response']['coach'] = (new Startup($db))->getStartupMemberList($id,'coach'); // we store the coach list
          $json['response']['staff'] = (new Startup($db))->getStartupMemberList($id,'staff'); // we store the staff list
        } else {
          $json['response'] = (new Startup($db))->getStartupMemberList($id,$typeUser); // we store the learner list for the requested user type
        }
        echo json_encode($json); // we return all the information in json

      }

    }

  } elseif ($type == 'startupInformation') {

    if ( !isset($_GET['id']) ) {
      // if we don't receive any startup ID
      // we store the error, we send it back and we kill he script

      $json['request']['status'] = 'error';
      $json['request']['message'] = 'Sorry you can\'t access to this page. A paramater is missing.';
      echo json_encode($json); // we return all the information in json
      die(); // we kill the script

    } else {

      $id = filter_var($_GET['id'], FILTER_VALIDATE_INT); // we check if the ID is valid

      if ($id == false) {
        // if ID is not a valid integer
        // we store the error, we send it back and we kill he script

        $json['request']['status'] = 'error';
        $json['request']['message'] = 'Sorry you can\'t access to this page. A paramater was invalid.';
        echo json_encode($json); // we return all the information in json
        die(); // we kill the script

      } else {

        $json['request']['status'] = 'success';
        $json['request']['message'] = 'Congrats. You have all the requested information.';
        $json['response'] = (new Startup($db))->getStartupInformation($id); // we store the startup information
        echo json_encode($json); // we return all the information in json

      }

    }

  }

}

?>
