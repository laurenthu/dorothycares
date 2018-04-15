<?php

require_once '../srv/_config.php';

//var_dump($_GET);

$json = [];
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

if(!isset($_GET['id'])) {

  $json['request']['status'] = 'error';
  $json['request']['message'] = 'Sorry you can\'t access to this page without the right parameters';
  echo json_encode($json);
  die(); // we kill the script

} else {

  $u = new User($db);

  $json['request']['status'] = 'success';
  $json['request']['message'] = 'Congrats. You have all the requested information.';
  $json['response']['email'] = $u->getEmailUserBySessionIdUser($_GET['id']);
  $json['response']['token'] = $u->getTokenUserBySessionIdUser($_GET['id']);
  echo json_encode($json);
  die(); // we kill the script

}
