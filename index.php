<?php

  // we start a session
  session_start();
  $_SESSION['token'] = sha1(rand());

  // we include the config
  include('srv/_config.php');

?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Dorothy Communication Terminal</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://fonts.googleapis.com/css?family=Source+Code+Pro:200,400,700" rel="stylesheet">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <header class="round">
          <div class="round-group">
            <div class="round-item round-bg">
              <div class="round-item round-top"></div>
              <div class="round-item round-top"></div>
            </div>
          </div>
        </header>
        <main class="terminal">
          <header class="terminal-header">
            <div class="terminal-header-item">Terminal session</div>
            <div class="terminal-header-item">
              <button class="terminal-header-btn minimize" disabled><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
              <button class="terminal-header-btn maximize"><i class="fa fa-window-maximize" aria-hidden="true"></i></button>
              <button class="terminal-header-btn close"><i class="fa fa-times" aria-hidden="true"></i></button>

            </div>
          </header>
          <div class="terminal-content">
            <div class="message">
              ********************************************<br>
              * I'm still learning from you.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*<br>
              * So I'm constantly upgrading my skills.&nbsp;&nbsp;&nbsp;*<br>
              * All commands of last week are inactive.&nbsp;&nbsp;*<br>
              ********************************************<br>
              &nbsp;
            </div>
            <div class="instruction">
              <div class="user-request"><span class="user">dorothy@becode</span><span class="symbol">:~$</span><span class="request">connexion</span></div>
              <div class="answer">Hello, I'm so glad to meet you!</div>
            </div>
            <!-- <div class="instruction">
              <div class="user-request">
                <span class="user">dorothy@becode</span><span class="symbol">:~$</span><span class="terminal-control"><input type="text" class="request" name="input"></span>
              </div>
            </div> -->
            <div class="instruction">
              <div class="user-request">
                <span class="user">dorothy@becode</span><span class="symbol">:~$</span><span class="terminal-control"><div class="user-input"></div><span class="terminal-symbol">_</span></span>
              </div>
            </div>
          </div>
          <footer class="terminal-footer">Created by "The Nine" - <a href="http://www.becode.org" target="_blank">BeCode Project</a> - <a href="cookies-policy.html" target="_blank">Cookies policy</a></footer>
        </main>

        <!-- JS Insertion -->
        <script src="js/vendor/modernizr-3.5.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
