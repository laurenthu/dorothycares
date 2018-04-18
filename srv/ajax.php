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
    $type = 'getProfile';
  }


  if ($type == 'updateProfile') {

    $optionsList = (new System($db))->getOptionList('linkType'); // we recup list option for website
    foreach($optionsList as $k => $v) {
      $options[$key]=$v['value'];
    }

    foreach($jsonData->user as $key => $value) {

    if ($value != '' && $key == 'firstName') { // we update first name if not empty

      if($u->updateUserFirstName($_SESSION['email'],$value) == false) {
        $json['error']['firstName'] = 'Impossible to save your first name';
      }

    } elseif ($value != '' && $key == 'lastName') { // we update last name if not empty

      if($u->updateUserLastName($_SESSION['email'],$value) == false) {
        $json['error']['lastName'] = 'Impossible to save your last name';
      }

    } elseif ($value != '' && $key == 'mainLanguage') { // we update main language if not empty

      if($u->updateUserMainLanguageCode($_SESSION['email'],$value) == fasle) {
        $json['error']['mainLanguage'] = 'Impossible to save your language selection';
      }

    } elseif (in_array($value,$options)) {

      $idOption = array_search($value,$options);
      $idUser = $u->getUserId($_SESSION['email']);

      // update database meta user for this value
      if($u->updateUserMeta($idUser, $idOption, $value) == false) {
        $json['error'][$value] = 'Impossible to save your '.$value;
      }

    } else {

      $idOption = (new System($db))->getOptionId($value);
      $idUser = $u->getUserId($_SESSION['email']);

      // create value into database meta user
      if($u->addUserMeta($idUser, $idOption, $value)) {
        $json['error'][$value] = 'Impossible to save your '.$value;
      }

    }

  }

} elseif ($type == 'getProfile') {
  $josn = array();
  $json['fistName'] = $u->getUserFirstName($_SESSION['email']);
  $json['lastName'] = $u->getUserLastName($_SESSION['email']);
  $json['mainLanguage'] = $u->getUserMainLanguageCode($_SESSION['email']);
  $json['meta'] = $u->getUserInformationAllMeta($_SESSION['email']);

}

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($json);


 ?>
