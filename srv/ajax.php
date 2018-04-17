<?php

  // we insert the config file
  include('_config.php');

  $u = new User($db);

  //echo $_POST['query'];
  //json_decode($json)
  $jsonData = json_decode(trim(file_get_contents('php://input')), true);
  $jsonData = json_decode($jsonData['formAnswer']);
  //var_dump($jsonData);

  if ($jsonData->type == 'profileUpdate') {

    foreach($jsonData->user as $key => $value) {

      if ($value != '' && $key == 'firstName') { // we update first name if not empty

        $u->updateUserFirstName($_SESSION['email'],$value);

      } elseif ($value != '' && $key == 'lastName') { // we update last name if not empty

        $u->updateUserLastName($_SESSION['email'],$value);

      } elseif ($value != '' && $key == 'mainLanguage') { // we update main language if not empty

        $u->updateUserMainLanguageCode($_SESSION['email'],$value);

      }

    }

  }

  /*foreach ($jsonData as $value) {
    print_r($value);
  }*/



 ?>
