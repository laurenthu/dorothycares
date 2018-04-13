<?php
  require_once "srv/_config.php";

  if (!isset($_SESSION['access_token'])) {
    header('Location: login.php');
    exit();
  }

?>
<!doctype html>
<html class="no-js" lang="">
<head>
    <!--<meta http-equiv="refresh" content="4">-->
	<meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:100,300" rel="stylesheet">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/main.css">
  <title>DorothAI <?php echo VERSION ?> (Beta)</title>

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

</head>
  <body id="body">

    <!--Canvas container for the particles-->
  	<canvas id="canvas"></canvas>

    <!-- Date and time -->
    <nav class="os-bar">
      <div class="os-bar__date-time"></div>
    </nav>

    <!-- Main ball -->
    <div class="dorothy-ball-container">
      <div class="dorothy-ball"></div>
    </div>

    <!-- Welcome message at beginning -->
    <div id="welcomeMessageContainer" class="welcome-message-style">
      <h1>Hey fellow becoder, <span></span></h1>
    </div>

    <!-- Menu -->
    <div class="ball-menu">
      <div class="ball-menu-item menu-terminal"><i class="fa fa-terminal"></i></div>
      <div class="ball-menu-item-label terminal-label">Terminal</div>
      <div class="ball-menu-item menu-profile"><i class="fa fa-user"></i></div>
      <div class="ball-menu-item-label profile-label">Profile</div>
      <div class="ball-menu-item menu-info"><i class="fa fa-info"></i></div>
      <div class="ball-menu-item-label info-label">About</div>
      <div class="ball-menu-item menu-calendar"><i class="fa fa-calendar"></i></div>
      <div class="ball-menu-item-label calendar-label">Calendar</div>
    </div>

    <!-- Terminal -->
    <main class="terminal" id="terminal"> <!--Box container for header with button and input/output-->
      <header class="terminal-header" id="terminal-header" value="terminal">
				<!-- <div><span class="window-name" id="window-name">Terminal</span></div>  -->
				<div class="terminal-header-item" id="terminal-header-item">
					<button class="terminal-header-btn maximize" id="maximize"></button>
					<button class="terminal-header-btn close" id="close" value="close">
          </button>
				</div>
			</header>
			<div class="terminal-content customScroll">  <!--Content inside the terminal i/o, interaction with dorothy by text-->
        <div class="instruction">
          <div class="user-request">
            <span class="user"></span> <!-- can be removed -->
            <span class="symbol"></span> <!-- can be removed -->
            <span class="request"></span>
          </div>
          <div class="answer" style="display:none;">Hey, what's up?</div>
        </div>
        <div class="instruction" style="display:none;">
          <div class="user-request">
            <span class="user"></span> <!-- can be removed -->
            <span class="symbol"></span> <!-- can be removed -->
            <span class="terminal-control">
              <div class="user-input"></div>
              <span class="terminal-symbol">_</span>
            </span>
          </div>
        </div>
      </div>
		</main>

    <!-- Profile page -->
    <section id="profilePage">

    </section>

    <!-- Info page -->
    <section id="infoPage">

    </section>

    <!-- Long answer template (for long answers e.g. about a specific coding language) -->
    <section id="answerTemplate">
      <div class="modal-container">
        <div class="modal-header">
          <div id="answer-modal-btn" class="modal-close-btn"></div>
        </div>
        <div class="modal-body">
          <h1 class="modal-body-title">PHP</h1>
          <div class="modal-body-block">
            <h3 class="modal-body-block-title">What is PHP?</h3>
            <div class="modal-body-block-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit, labore, tempora. A et voluptas cum, esse eum culpa pariatur tenetur praesentium dicta? Esse nobis voluptatibus architecto minima ea sint nostrum?</div>
          </div>
          <div class="modal-body-block">
            <h3 class="modal-body-block-title">How to install PHP?</h3>
            <div class="modal-body-block-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus molestias, vero non ad natus pariatur explicabo culpa error sint totam eos quas incidunt, architecto suscipit, rem ut veritatis doloribus eligendi. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque ullam fugiat dignissimos. Eum quod nisi cumque perferendis magnam porro, tempore, fuga molestiae adipisci ex eos ut amet magni nam voluptas!</div>
          </div>
          <div class="modal-body-block">
            <h3 class="modal-body-block-title">How to install PHP?</h3>
            <div class="modal-body-block-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus molestias, vero non ad natus pariatur explicabo culpa error sint totam eos quas incidunt, architecto suscipit, rem ut veritatis doloribus eligendi. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque ullam fugiat dignissimos. Eum quod nisi cumque perferendis magnam porro, tempore, fuga molestiae adipisci ex eos ut amet magni nam voluptas!</div>
          </div>
          <div class="modal-body-block">
            <h3 class="modal-body-block-title">How to install PHP?</h3>
            <div class="modal-body-block-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus molestias, vero non ad natus pariatur explicabo culpa error sint totam eos quas incidunt, architecto suscipit, rem ut veritatis doloribus eligendi. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque ullam fugiat dignissimos. Eum quod nisi cumque perferendis magnam porro, tempore, fuga molestiae adipisci ex eos ut amet magni nam voluptas!</div>
          </div>
        </div>
      </div>
    </section>

  <!-- JS Insertion -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.2.0/anime.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <script>
    window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')
  </script>
  <script src="js/main.js"></script>
  <script src="js/vendor/modernizr-3.5.0.min.js"></script>
  <!-- <script src="js/terminal-animation.js"></script> -->
  <!-- <script src="js/button-interaction.js"></script> -->
  <script src="js/plugins.js"></script>
  <script src="js/anchorme.min.js"></script>
  <!-- <script src="js/background-animation.js"></script> -->

  <!--
  Dev var_dump
    <?php
      $i = new Implantation($db);
      $s = new Startup($db);
      $u = new User($db);
      $sy = new System($db);
      //print_r( $u->checkGoogleIdUser($_SESSION['email']) );
      //print_r( $sy->getCountryList() );
      //echo formHTML::getFormSelectFromArray( $sy->getCountryList(), 'country', 'country', 'country', 'fr' );
      //var_dump($s->addStartup('test',2));
      var_dump($_SESSION);
      //echo phpversion();
    ?>
  -->

</body>

</html>
