<?php
  require_once "srv/config.php";

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
    <title>Login</title>
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
        <!-- <div class="g-signin2" data-onsuccess="onSuccess">
          <div style="height:36px;width:120px;" class="abcRioButton abcRioButtonLightBlue">
            <div class="abcRioButtonContentWrapper">
              <div class="abcRioButtonIcon" style="padding:8px">
                <div style="width:18px;height:18px;" class="abcRioButtonSvgImageWithFallback abcRioButtonIconImage abcRioButtonIconImage18">
                  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 48 48" class="abcRioButtonSvg">
                    <g>
                      <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                      <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                      <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                      <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                      <path fill="none" d="M0 0h48v48H0z"></path>
                    </g>
                  </svg>
                </div>
              </div>
              <span style="font-size:13px;line-height:34px;" class="abcRioButtonContents">
                <span id="not_signed_inxkepb5ml42zf" style="">Connexion</span>
                <span id="connectedxkepb5ml42zf" style="display: none;">Signed in</span>
              </span>
            </div>
          </div>
        </div> -->
      <!-- </div>
    </main> -->
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
