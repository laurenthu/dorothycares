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

// General constants
define('HOME_URL','');
define('SCRIPT_DIR','');
define('VERSION','');

// we include the GoogeAPI files
require_once SCRIPT_DIR.'/GoogleAPI/vendor/autoload.php';

// insert class files
require_once SCRIPT_DIR.'/class/class.user.php';
require_once SCRIPT_DIR.'/class/class.implantation.php';
require_once SCRIPT_DIR.'/class/class.startup.php';
require_once SCRIPT_DIR.'/class/class.system.php';
require_once SCRIPT_DIR.'/class/class.form.php';

?>
