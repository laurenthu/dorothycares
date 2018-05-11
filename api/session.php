<?php

// include config file
require_once '../srv/_config.php';

$json = []; // create en empty array
header('Access-Control-Allow-Origin: *'); // to allow any resource to access the resources
header('Content-type: application/json'); // to indicate the  type of the resource

if(!isset($_GET['id'])) {
  // if we don't receive any implantation ID
  // we store the error, we send it back and we kill he script

  $json['request']['status'] = 'error';
  $json['request']['message'] = 'Sorry you can\'t access to this page without the right parameters';
  echo json_encode($json);
  die(); // we kill the script

} else {

  $u = new User($db);

  $json['request']['status'] = 'success';
  $json['request']['message'] = 'Congrats. You have all the requested information.';
  $json['response']['email'] = $u->getEmailUserBySessionIdUser($_GET['id']); // we store the email of the user
  $json['response']['token'] = $u->getTokenUserBySessionIdUser($_GET['id']); // we store the token of the user
  echo json_encode($json); // we write json response
  die(); // we kill the script

}
