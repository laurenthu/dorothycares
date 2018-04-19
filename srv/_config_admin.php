<?php

 /* uncomment FOR DEBUG */
 error_reporting(E_ALL);
 ini_set('display_errors', 1);

 // Constants for database connexion
 define('DB_HOST', 'localhost'); // Database Hostname
 define('DB_NAME', 'admin_dorothy'); // Database Name
 define('DB_USER', 'root'); // Database Username
 define('DB_PASS', 'user'); // Database Password

 $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);

 session_start();
 require_once "../GoogleAPI/vendor/autoload.php";
 $gClientAdmin = new Google_Client(); // User
 $gClientAdmin->setClientId("885981723240-3f7e0fvnvq967bmq7aqm386csavio23j.apps.googleusercontent.com");
 $gClientAdmin->setClientSecret("nc0K3Q2p00GjtRVel9yyZ53k");
 $gClientAdmin->setApplicationName("Dorothy Login System");
 $gClientAdmin->setRedirectUri("http://localhost:8080/admin/google-signin-callback.php");
 $gClientAdmin->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me");

 // General constants
 define('SCRIPT_DIR','/home/alexandrentougas/Sites/GitHub/Dorothy/os-simulation/class');
 define('VERSION','0.20');

 // insert class files
 require_once SCRIPT_DIR.'/class.user.php';
 require_once SCRIPT_DIR.'/class.system.php';
 require_once SCRIPT_DIR.'/class.startup.php';
 require_once SCRIPT_DIR.'/class.implantation.php';
 require_once SCRIPT_DIR.'/class.form.php';
?>
