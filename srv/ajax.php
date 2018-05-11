<?php

  // we insert the config file
  include('_config.php');

  $u = new User($db);

  //echo $_POST['query'];
  //json_decode($json)
  $jsonData = json_decode(trim(file_get_contents('php://input')), true);
  $jsonData = json_decode($jsonData['formAnswer']);
  //var_dump($jsonData);


  if ( !isset($_GET['type']) ) {
    $type = 'updateProfile';
  } else {
    $type = $_GET['type'];
  }


  if ($type == 'updateProfile') {

    $err = 0;

    $optionsList = (new System($db))->getOptionList('linkType'); // we recup list option for website
    foreach($optionsList as $k => $v) {
      $options[$v['id']]=$v['value'];
    }

    foreach($jsonData->user as $key => $value) {

      if ($value != '' && $key == 'firstName') { // we update first name if not empty

        if($u->updateUserFirstName($_SESSION['email'],$value) == false) {
          $json['error']['firstName'] = 'Impossible to save your first name';
          $err++;
        }

      } elseif ($value != '' && $key == 'lastName') { // we update last name if not empty

        if($u->updateUserLastName($_SESSION['email'],$value) == false) {
          $json['error']['lastName'] = 'Impossible to save your last name';
          $err++;
        }

      } elseif ($value != '' && $key == 'mainLanguage') { // we update main language if not empty

        if($u->updateUserMainLanguageCode($_SESSION['email'],$value) == false) {
          $json['error']['mainLanguage'] = 'Impossible to save your language selection';
          $err++;
        }

      } elseif (in_array($key,$options)) {

        $idOption = array_search($key,$options);
        $idUser = intval($u->getUserId($_SESSION['email']));

        if ($u->getUserInformationOneMeta($_SESSION['email'], $key) == false && $value != '') { // elle n'existe pas encore dans la bdd, on la crée

          if($u->addUserMeta($idUser, $idOption, $value) == false) {
            $json['error'][$idOption] = 'Impossible to add your '.$value;
            $err++;
          }

        } elseif ($u->getUserInformationOneMeta($_SESSION['email'], $key) != false && $value == '') { // elle existe dans la bdd mais la nouvelle valeur est vide, on delete

          if($u->deleteUserMeta($idUser, $idOption) == false) {
            $json['error'][$idOption] = 'Impossible to delete '.$value.' from the database';
            $err++;
          }

        } elseif ($u->getUserInformationOneMeta($_SESSION['email'], $key) != false && $value != '') { // elle existe et la nouvelle valeur n'est pas vide, on update

          if($u->updateUserMeta($idUser, $idOption, $value) == false) {
            $json['error'][$idOption] = 'Impossible to save '.$value.' into the database';
            $err++;
          }

        }

      }

  } // end foreach

  if ($err == 0) {
    $json['request']['status'] = 'success';
    $json['request']['message'] = 'Congrats. You have all the requested information.';
  } else {
    $json['request']['status'] = 'error';
    $json['request']['message'] = 'There are some errors in the request';
  }

} elseif ($type == 'getProfile') {
  $josn = array();
  $json['firstName'] = $u->getUserFirstName($_SESSION['email']);
  $json['lastName'] = $u->getUserLastName($_SESSION['email']);
  $json['mainLanguage'] = $u->getUserMainLanguageCode($_SESSION['email']);
  $json['meta'] = $u->getUserInformationAllMeta($_SESSION['email']);

}

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($json);


 ?>
