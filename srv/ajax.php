<?php

  // we start a session
  session_start();

  // we insert the config file
  include('_config.php');

  // we store the value
  $userInstruction = trim(strtolower($_POST['instruction'])); // we store the value send the user

  // we the current date (now!)
  $nowTimer = new DateTime();
  $randomSeconds = rand(3,10);


  if(!isset($_SESSION['token'])) {  // we check if the token is present (and so if he arrive from index.php)
    echo 'Your security token has expired. To secure the line again, you need to refresh the terminal.'; // we print the message
    $db = null; // we close db connection
    die(); // we kill the rest of the code
  }

  if(!isset($_SESSION['nextPostTimer'])) { // if the time doesn't exist we create it
    $_SESSION['nextPostTimer'] = new DateTime(); // we create a new Date object
    $_SESSION['nextPostTimer']->modify('+'.$randomSeconds.' seconds'); // we add the timer
  } else if ($_SESSION['nextPostTimer'] > $nowTimer) { // if timer exists, we test if he could already post
    $_SESSION['nextPostTimer']->modify('+'.$randomSeconds.' seconds'); // we add the time
    if ($userInstruction == 'timer') {
      echo 'You will be able to post again on '.$_SESSION['nextPostTimer']->format('d/m/Y H:i:s'); // we send the information
      $db = null; // we close db connection
      die(); // we kill the rest of the code
    }
    echo 'Dear spammer, you must wait a little before typing the next instruction. So don\'t be a troll.<br><strong>Notice:</strong> Security timers can be cumulated.'; // we print the message
    $db = null; // we close db connection
    die(); // we kill the rest of the code
  } else { //  // if exist and he can post again
    $_SESSION['nextPostTimer'] = new DateTime();
    $_SESSION['nextPostTimer']->modify('+'.$randomSeconds.' seconds'); // we add the time
  }

  if ($userInstruction == 'timer'){
    echo 'You will be able to post again on '.$_SESSION['nextPostTimer']->format('d/m/Y H:i:s'); // we send the information
    $db = null; // we close db connection
    die(); // we kill the rest of the code
  }

  if ($userInstruction == '') { // we check if it's not empty
    echo 'No empty command please'; // we print the message
    $db = null; // we close db connection
    die(); // we kill the rest of the code
  } elseif ( strlen($userInstruction) == 1 ) { // we test if the command has a length > 1
    echo 'No one-letter command please'; // we print the message
    $db = null; // we close db connection
    die(); // we kill the rest of the code
  } else {
    $answer = 'Unknown command '.$userInstruction; // we give a default message
  }

  $db = null; // we close database connexion
  echo $answer; // we return the answer

 ?>
