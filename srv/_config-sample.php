<?php

/* uncomment FOR DEBUG */
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Constants for database connexion
define('DB_HOST', ''); // Database Hostname
define('DB_NAME', ''); // Database Name
define('DB_USER', ''); // Database Username
define('DB_PASS', ''); // Database Password

$db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);

// we start a session
session_start();

// we include the GoogeAPI files
require_once "GoogleAPI/vendor/autoload.php";

// we initialize the Google Client object

$gClient = new Google_Client();
$gClient->setClientId("");
$gClient->setClientSecret("");
$gClient->setApplicationName("");
$gClient->setRedirectUri("");
$gClient->addScope("");

// General constants
define('SCRIPT_DIR','');
define('VERSION','');

// insert class files
require_once SCRIPT_DIR.'/class.user.php';


?>
