<?php
  require_once "srv/_config.php";
  require_once "srv/_google-signin-client.php";

  if (isset($_SESSION['access_token'])) {
    header('Location: '.HOME_URL.'login/');

    exit();
  }

  $loginURL = $gClient->createAuthUrl();
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login - DorothyCares <?php echo VERSION ?> (Dev)</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:100,300|Roboto:500" rel="stylesheet">

    <!-- Google Sign-In -->
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="269528235107-8m2673golc384phuudm0p8aj4mtb7hi0.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://apis.google.com/js/api.js"></script>

    <!-- OpenGraph -->
    <meta property="fb:app_id" content="306159282727976">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="DorothyCares">
    <meta property="og:description" content="Dorothy cares about you. It'll help you along your way at BeCode.">
    <meta property="og:url" content="https://dorothycares.io/">
    <meta property="og:site_name" content="DorothyCares">
    <meta property="og:image" content="https://dorothycares.io/img/printscreen.jpg">
    <meta property="og:image:secure_url" content="https://dorothycares.io/img/printscreen.jpg">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:description" content="Dorothy cares about you. It'll help you along your way at BeCode.">
    <meta name="twitter:title" content="DorothyCares">
    <meta name="twitter:site" content="@becodeorg">
    <meta name="twitter:image" content="https://dorothycares.io/img/printscreen.jpg">

    <!-- CSS -->
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/main.css">

    <!-- Google Tag Manager -->
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-WCDFFXV');</script>

  </head>

  <body>

    <!-- Google Tag Manager (noscript) -->
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WCDFFXV"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- login window with Google Sign in button -->
    <main class="login-interface" data-onsuccess="onSignIn" id="login-interface">
      <div class="container-login">
        <div class="welcome"></div>
        <div class="google-button" data-location="<?php echo $loginURL ?>">
          <div class="google-button-block">
            <div class="logo">
              <img src="/img/google-logo.png" alt="Google Logo">
            </div>
            <div class="call-to-action">
              <span>Sign in with Google</span>
            </div>
          </div>
        </div>
    </main>

    <!-- JS Insertion -->
    <script src="/js/modernizr-3.5.0.min.js"></script>
    <script src="/js/login.js"></script>
  </body>
</html>
