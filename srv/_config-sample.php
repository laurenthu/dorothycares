<?php

define('DB_HOST', ''); // Database Hostname
define('DB_NAME', ''); // Database Name
define('DB_USER', ''); // Database Username
define('DB_PASS', ''); // Database Password

$db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);

/* uncomment FOR DEBUG */
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

?>
