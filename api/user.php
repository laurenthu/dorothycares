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
    echo json_encode($json); // we return all the information in json
    die(); // we kill the script

  } else {
    // if values exist, we check if they're valid and we clear them

    $email = filter_var($_GET['emailUser'], FILTER_SANITIZE_EMAIL); // Remove all characters except letters, digits and !#$%&'*+-=?^_`{|}~@.[].
    $token = filter_var($_GET['tokenUser'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); // remove all characters that have a numerical value >127.
    $type = filter_var($_GET['type'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); // remove all characters that have a numerical value >127.

  }

  $u = new User($db);

  if( !$u->checkPassworduser($email,$token) ) {
    // we check if the password of the user is valid thanks to his email and his token
    // if not, we store the error, we send it back and we kill he script

    $json['request']['status'] = 'error';
    $json['request']['message'] = 'Sorry you can\'t access to this page. Your token is invalid.';
    echo json_encode($json); // we return all the information in json
    die(); // we kill the script

  } else {
    // if all the data are valid, we check what kind of data we request

    if ($type == 'coachUser') {

      $startupId = $u->getUserStartupId($email); // we store the startup ID of the user
      $coach = (new Startup($db))->getStartupMemberList($startupId,'coach'); // we initialize the object and we call the method,

      $json['request']['status'] = 'success';
      $json['request']['message'] = 'Congrats. You have all the requested information.';
      $json['response'] = $coach; // we store the coach information of the user
      echo json_encode($json); // we return all the information in json

    } elseif ($type == 'implantationUser') {

      $json['request']['status'] = 'success';
      $json['request']['message'] = 'Congrats. You have all the requested information.';
      $json['response'] = (new Implantation($db))->getImplantationInformation($u->getUserImplantationId($email)); // we store the information about the implantation of the user
      echo json_encode($json); // we return all the information in json

    } elseif ($type == 'startupUser') {

      $json['request']['status'] = 'success';
      $json['request']['message'] = 'Congrats. You have all the requested information.';
      $json['response'] = (new Startup($db))->getStartupInformation($u->getUserStartupId($email)); // we store the information about the startup of the user
      echo json_encode($json); // we return all the information in json

    } elseif ($type == 'informationUser') {

      $json['request']['status'] = 'success';
      $json['request']['message'] = 'Congrats. You have all the requested information.';
      $json['response'] = $u->getUserInformation($email); // we store the information about the user
      echo json_encode($json); // we return all the information in json

    }

  }



?>
