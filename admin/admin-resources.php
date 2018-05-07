<?php
  require_once 'srv/_config_admin.php';

  // if (!isset($_SESSION['access_token'])) {
  //   header('Location: login.php');
  //   exit();
  // } else {
  //   header('Location: admin.php');
  //   exit();
  // }


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <!-- <link rel="stylesheet" href="css/materialize.min.css"> -->
    <link rel="stylesheet" href="css/admin-resources.css">
  </head>
  <body>  
    <div class="row">
      <div class="col s12">
        <ul class="tabs tabs-fixed-width">
          <li class="tab col s6"><a class="active" href="#resources" data-type="resources">Resources</a></li>
          <li class="tab col s6"><a href="#toolbox" data-type="toolbox">Toolbox</a></li>
        </ul>

        <div id="resources" class="col s12">
          <div id="resourcesIcons"></div>

          <div id="resourcesInfo">
            <div class="row">
              <div class="col s12">
                <div class="card horizontal">
                  <div id="resourcesCardName" class="card-content"></div>
                  <div id="resourcesCardInfos" class="card-stacked">
                    <div class="card-content">
                      <span>Name : </span>
                      <p id="cardName"></p>
                    </div>
                    <div class="card-content">
                      <span>Name displayed : </span>
                      <p id="cardDisplayName"></p>
                    </div>
                    <div class="card-content">
                      <span>Introduction</span>
                      <p id="cardIntro"></p>
                    </div>
                    <div class="card-content">
                      <span>Installation</span>
                      <p id="cardInstallation"></p>
                    </div>
                    <div class="card-content">
                      <span>Documentation</span>
                      <p id="cardDocumentation"></p>
                    </div>
                    <div class="card-content">
                      <span>Tutorials</span>
                      <p id="cardTutorials"></p>
                    </div>
                    <div class="card-content">
                      <span>Exercices</span>
                      <p id="cardExercices"></p>
                    </div>
                    <div class="card-content">
                      <span>Examples</span>
                      <p id="cardExamples"></p>
                    </div>
                    <div class="card-content">
                      <span>News</span>
                      <p id="cardNews"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div id="toolbox" class="col s12">
        
        </div>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <!-- <script type="js/materialize.min.js"></script> -->
    <script src="js/admin-resources.js"></script>
  </body>
</html>
