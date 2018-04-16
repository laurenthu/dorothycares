<?php
  require_once "srv/_config.php";

  if (!isset($_SESSION['access_token'])) {
    header('Location: '.HOME_URL.'login/');
    exit();
  }

?>
<!doctype html>
<html class="no-js" lang="en">
<head>

	<meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">

  <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:100,300|Roboto:500" rel="stylesheet">
  <link rel="stylesheet" href="/css/font-awesome.min.css">
  <link rel="stylesheet" href="/css/normalize.css">
	<link rel="stylesheet" href="/css/main.css">

  <title>DorothyCares <?= VERSION ?></title>

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

<body id="body" data-email="<?= $_SESSION['email']; ?>" data-token="<?= $_SESSION['token'] ?>" data-dialogflow-session="<?= session_id();?>">

  <!--Canvas container for the particles-->
	<canvas id="canvas"></canvas>

  <!-- Hiding background div for modals -->
  <div id="hiding-bg-div" class="hiding-bg-div"></div>

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
				<button class="terminal-header-btn close" id="close" value="close"></button>
			</div>
		</header>
		<div class="terminal-content customScroll">  <!--Content inside the terminal i/o, interaction with dorothy by text-->
      <div class="instruction">
        <div class="answer">Hey, what's up?</div>
      </div>
      <div class="instruction">
        <div class="user-request">
          <span class="terminal-control">
            <div class="user-input"></div>
            <span class="terminal-symbol">_</span>
          </span>
        </div>
      </div>
    </div>
	</main>

  <!-- Profile page -->
  <!-- <section id="profilePage">
    <div class="modal-container-2">
      <div class="modal-body-2">

        <div class="modal-body-title-container">
          <div class="modal-body-title-title"><h1 class="modal-body-title">PROFILE</h1></div>
          <div class="modal-body-title-icons">
            <a href="/logout/"><i id="profile-logout" class="profile-logout fa fa-power-off tooltip" aria-hidden="true"><span class="tooltiptext">logout</span></i></a>
          </div>
        </div>

        <form id="profile-details" class="profile-details" action="" method="">
          <span class="profile-input-wrapper">
            <label for="profile-lastname">LAST NAME</label>
            <input id="profile-lastname" class="profile-lastname" type="text" placeholder="Dorothy">
          </span>
          <span class="profile-input-wrapper">
            <label for="profile-firstname">FIRST NAME</label>
            <input id="profile-firstname" class="profile-firstname" type="text" placeholder="Cares">
          </span>
          <span class="profile-input-wrapper">
            <label for="profile-language">LANGUAGE</label>
            <input id="profile-language" class="profile-language" type="radio" checked="checked" name="ENG"><label class="english">En</label>
          </span>
          <span class="profile-input-wrapper">
            <label for="profile-github">GITHUB</label>
            <input id="profile-github" class="profile-github" type="text" name="Github account" placeholder="Github">
          </span>
          <span class="profile-input-wrapper">
            <label for="profile-linkedin">LINKEDIN</label>
            <input id="profile-linkedin" class="profile-linkedin" type="text" placeholder="Linkedin">
          </span>
          <div class="profile-buttons">
            <button id="profile-save-details" class="profile-save-details">Save</button>
          </div>
        </form>

      </div>

      <div class="modal-header-2">
        <div id="profile-modal-btn" class="modal-close-btn-2"></div>
      </div>

    </div>
  </section> -->


  <!-- Info page -->
  <section id="infoPage">
    <div id="modal-container-3">
      <div id="modal-body-info" class="modal-body-info">
        <h1 class="modal-info-title">DorothyCares<span class="version">v<?= VERSION ?></span></h1>
        <h5 class="modal-info-creators">Powered by "The Nine"</h5>
        <a class="modal-info-link" href="https://www.becode.org/">A Becode Project</a>
        <a class="modal-info-link" href="/policy/cookies-policy.html">Cookies-Policy</a>
        <a class="modal-info-link" href="/policy/privacy.html">Privacy</a>
      </div>
    </div>
  </section>

  <!-- Long answer template (for long answers e.g. about a specific coding language) -->
  <section id="answerTemplate">
    <div class="modal-container">
      <div class="modal-header">
        <div id="answer-modal-btn" class="modal-close-btn"></div>
      </div>
      <div class="modal-body"></div>
    </div>
  </section>

  <!-- JS Insertion -->
  <script src="/js/anime.min.js"></script> <!-- http://animejs.com/ -->
  <script src="/js/modernizr-3.5.0.min.js"></script> <!-- https://modernizr.com/ -->
  <script src="/js/plugins.js"></script>
  <script src="/js/anchorme.min.js"></script> <!-- https://github.com/alexcorvi/anchorme.js/ -->
  <script src="/js/axios.min.js"></script> <!-- https://github.com/axios/axios -->
  <script src="/js/main.js"></script>
  <script src="/js/dialogflow.js"></script>

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
