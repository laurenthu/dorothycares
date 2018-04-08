<?php
  require_once "srv/_config.php";

  if (isset($_SESSION['access_token'])) {
    header('Location: login.php');
    exit();
  }

  $loginURL = $gClient->createAuthUrl();
?>
<!DOCTYPE html>
<html class="no-js" lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login - DorothAI Cares <?php echo VERSION ?> (Dev)</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Sign-In -->
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="269528235107-8m2673golc384phuudm0p8aj4mtb7hi0.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://apis.google.com/js/api.js"></script>
    <!-- OpenGraph -->
    <meta property="fb:app_id" content="306159282727976">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="DorothAI">
    <meta property="og:description" content="Dorothy cares about you. Iy'll help you along your way at BeCode.">
    <meta property="og:url" content="https://dorothycares.io/">
    <meta property="og:site_name" content="DorothAI">
    <meta property="og:image" content="https://dorothycares.io/img/printscreen.jpg">
    <meta property="og:image:secure_url" content="https://dorothycares.io/img/printscreen.jpg">
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:description" content="Dorothy cares about you. It'll help you along your way at BeCode.">
    <meta name="twitter:title" content="DorothAI">
    <meta name="twitter:site" content="@becodeorg">
    <meta name="twitter:image" content="https://dorothycares.io/img/printscreen.jpg">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Code+Pro:200,400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
  </head>
  <body>
    <div id="particles-js"></div>
    <header class="round">
      <div class="round-group">
        <div class="round-item round-bg">
          <div class="round-item round-top"></div>
          <div class="round-item round-top"></div>
        </div>
      </div>
    </header>

    <main class="login-interface" data-onsuccess="onSignIn">
      <div class="container-login">
        <div class="welcome"></div>
        <div class="google-button" data-location="<?php echo $loginURL ?>">
          <div class="logo">
            <img src="img/g-logo.png" alt="">
          </div>
          <div class="call-to-action">
            Sign in with Google
          </div>
        </div>
    </main>
    <!-- JS Insertion -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script>
      window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')
    </script>
    <script src="js/plugins.js"></script>
    <script src="js/particles.min.js"></script>
    <script src="js/anchorme.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/login.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
  </body>
</html>
