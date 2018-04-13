<?php

// we initialize the Google Client object

$gClient = new Google_Client();
$gClient->setClientId(""); // Given by Google
$gClient->setClientSecret(""); // Given by Google
$gClient->setApplicationName("Dorothy Login System");
$gClient->setRedirectUri(HOME_URL."google-signin-callback.php");
$gClient->addScope(""); // Selected by User

?>
