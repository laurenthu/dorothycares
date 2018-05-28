<?php

  require_once "srv/_config.php";

  $GRPD = new DateTime('2018-05-25 00:00:01', new DateTimeZone('Europe/Brussels'));
  $now =  new DateTime(null, new DateTimeZone('Europe/Brussels'));

  if ($GRPD > $now) {

    if (!isset($_SESSION['access_token'])) {
      header('Location: '.HOME_URL.'login/');
      exit();
    } else {
      header('Location: '.HOME_URL.'app/');
      exit();
    }

  } else {

    header('Location: '.HOME_URL.'grpd.php');
    exit();

  }


  //echo $_SESSION['email'];
?>
