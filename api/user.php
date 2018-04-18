<?php

  require_once '../srv/_config.php';

  //var_dump($_GET);

  $json = [];
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json');

  if(!isset($_GET['emailUser']) || !isset($_GET['tokenUser'])) {

    $json['request']['status'] = 'error';
    $json['request']['message'] = 'Sorry you can\'t access to this page without the right parameters';
    echo json_encode($json);
    die(); // we kill the script

  } else {

    $email = filter_var($_GET['emailUser'], FILTER_SANITIZE_EMAIL); // Remove all characters except letters, digits and !#$%&'*+-=?^_`{|}~@.[].
    $token = filter_var($_GET['tokenUser'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); // remove all characters that have a numerical value >127.
    $type = filter_var($_GET['type'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); // remove all characters that have a numerical value >127.

  }

  $u = new User($db);

  if( !$u->checkPassworduser($email,$token) ) {

    $json['request']['status'] = 'error';
    $json['request']['message'] = 'Sorry you can\'t access to this page. Your token is invalid.';
    echo json_encode($json);
    die(); // we kill the script

  } else {

    if ($type == 'coachUser') {

      $startupId = $u->getUserStartupId($email);
      $coach = (new Startup($db))->getStartupMemberList($startupId,'coach'); // we initialize the object and we call the method

      $json['request']['status'] = 'success';
      $json['request']['message'] = 'Congrats. You have all the requested information.';
      $json['response'] = $coach;

      // we return all the information in json
      echo json_encode($json);

    } elseif ($type == 'implantationUser') {

      $json['request']['status'] = 'success';
      $json['request']['message'] = 'Congrats. You have all the requested information.';
      $json['response'] = (new Implantation($db))->getImplantationInformation($u->getUserImplantationId($email));

      // we return all the information in json
      echo json_encode($json);

    } elseif ($type == 'startupUser') {

      $json['request']['status'] = 'success';
      $json['request']['message'] = 'Congrats. You have all the requested information.';
      $json['response'] = (new Startup($db))->getStartupInformation($u->getUserStartupId($email));

      // we return all the information in json
      echo json_encode($json);

    } elseif ($type == 'informationUser') {

      $json['request']['status'] = 'success';
      $json['request']['message'] = 'Congrats. You have all the requested information.';
      $json['response'] = $u->getUserInformation($email);

      // we return all the information in json
      echo json_encode($json);

    }

  }



?>
