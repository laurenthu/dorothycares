<?php

require_once '../srv/_config.php';

//var_dump($_GET);

$json = [];

if(!isset($_GET['emailUser']) || !isset($_GET['tokenUser'])) {
  $json['request']['status'] = 'error';
  $json['request']['message'] = 'Sorry you can\'t access to this page without the right parameters';
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json');
  echo json_encode($json);
  die(); // we kill the script
} else {
  $email = filter_var($_GET['emailUser'], FILTER_SANITIZE_EMAIL); // Remove all characters except letters, digits and !#$%&'*+-=?^_`{|}~@.[].
  $token = filter_var($_GET['tokenUser'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); // remove all characters that have a numerical value >127.
  $type = filter_var($_GET['type'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); // remove all characters that have a numerical value >127.
}

if( !(new User($db))->checkPassworduser($email,$token) ) {

  $json['request']['status'] = 'error';
  $json['request']['message'] = 'Sorry you can\'t access to this page. Your token is invalid.';
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json');
  echo json_encode($json);
  die(); // we kill the script

} else {

  if ($type == 'implentationList') {


    $json['request']['status'] = 'success';
    $json['request']['message'] = 'Congrats. You have all the requested information.';
    $json['response'] = (new Implantation($db))->getImplantationList();

    // we return all the information in json
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    echo json_encode($json);

  } elseif ($type == 'implentationInformation') {

    if ( !isset($_GET['id']) ) {

      $json['request']['status'] = 'error';
      $json['request']['message'] = 'Sorry you can\'t access to this page. A paramater is missing.';
      header('Access-Control-Allow-Origin: *');
      header('Content-type: application/json');
      echo json_encode($json);
      die(); // we kill the script

    } else {

      $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

      if ($id == false) {

        $json['request']['status'] = 'error';
        $json['request']['message'] = 'Sorry you can\'t access to this page. A paramater was invalid.';
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        echo json_encode($json);
        die(); // we kill the script

      } else {

        $json['request']['status'] = 'success';
        $json['request']['message'] = 'Congrats. You have all the requested information.';
        $json['response'] = (new Implantation($db))->getImplantationInformation($id);
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        echo json_encode($json);

      }

    }

  }

}

?>
