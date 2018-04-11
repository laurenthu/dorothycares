<?php
  require_once "../srv/_config_admin.php";

  // if (!isset($_SESSION['access_token'])) {
  //   header('Location: login.php');
  //   exit();
  // } else {
  //   header('Location: admin.php');
  //   exit();
  // }

  $iCount = (new Implantation($db))->getImplantationCount(); // number of implantations
  $iNumberResults = 10; // you can change the number of results displayed here
  $iPageCount = ceil($iCount / $iNumberResults); // number of pages for the pagination

  $sCount = (new Startup($db))->getStartupCount(); // number of startups
  $sNumberResults = 10; // you can change the number of results displayed here
  $sPageCount = ceil($sCount / $sNumberResults); // number of pages for the pagination

  $uCount = (new User($db))->getUserCount(); // number of users
  $uNumberResults = 10; // you can change the number of results displayed here
  $uPageCount = ceil($uCount / $uNumberResults); // number of pages for the pagination
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <link rel="stylesheet" href="css/admin.css">
  </head>
  <body>

    <div class="row">
      <div class="col s12">
        <ul class="tabs">
          <li id="implantationTab" class="tab col s3"><a class="active" href="#implantation" data-type="implantation">Implantation</a></li>
          <li id="startupTab" class="tab col s3"><a href="#startup" data-type="startup">Startup</a></li>
          <li id="userTab" class="tab col s3"><a href="#utilisateur" data-type="user">Utilisateur</a></li>
        </ul>
      </div>
      <div id="implantation" class="col s12">

        <table class="responsive-table">

          <thead>
            <tr>
              <th>Nom</th>
              <th>Adresse</th>
              <th>Code postal</th>
              <th>Ville</th>
              <th>Pays</th>
              <th>Code pays</th>
            </tr>
          </thead>

          <tbody id="implantationTable">
            <!-- Table created with ajax request -->
          </tbody>

        </table>

        <ul class="pagination implantationPage" data-itemPerPage="<?php echo  $iNumberResults ?>" data-type="implantation">
          <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
          <li class="active" data-start="0"><a href="#!">1</a></li>
          <?php
            if ($iPageCount > 1) {
              for ($i = 2, $start = $iNumberResults; $i <= $iPageCount; $i++, $start += $iNumberResults) {
                echo '<li class="waves-effect" data-start="' . $start . '"><a href="#!">' . $i . '</a></li>';
              };
            };
          ?>
          <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul>

      </div>

      <div id="startup" class="col s12">

        <table class="responsive-table">

          <thead>
            <tr>
              <th>Nom</th>
            </tr>
          </thead>

          <tbody id="startupTable">
            <!-- Table created with ajax request -->
          </tbody>

        </table>

        <ul class="pagination startupPage" data-itemPerPage="<?php echo  $sNumberResults ?>" data-type="startup">
          <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
          <li class="active" data-start="0"><a href="#!">1</a></li>
          <?php
            if ($sPageCount > 1) {
              for ($i = 2, $start = $sNumberResults; $i <= $sPageCount; $i++, $start += $sNumberResults) {
                echo '<li class="waves-effect" data-start="' . $start . '"><a href="#!">' . $i . '</a></li>';
              };
            };
          ?>
          <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul>

      </div>

      <div id="utilisateur" class="col s12">

        <table class="responsive-table">

          <thead>
            <tr>
              <th>Prénom</th>
              <th>Nom</th>
              <th>Mail</th>
              <th>Type</th>
              <th>Langue</th>
            </tr>
          </thead>

          <tbody id="userTable">
            <!-- Table created with ajax request -->
          </tbody>

        </table>

        <ul class="pagination userPage" data-itemPerPage="<?php echo  $uNumberResults ?>" data-type="user">
          <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
          <li class="active" data-start="0"><a href="#!">1</a></li>
          <?php
            if ($uPageCount > 1) {
              for ($i = 2, $start = $uNumberResults; $i <= $uPageCount; $i++, $start += $uNumberResults) {
                echo '<li class="waves-effect" data-start="' . $start . '"><a href="#!">' . $i . '</a></li>';
              };
            };
          ?>
          <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul>

      </div>

   </div>

   <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
   <script src="js/admin.js"></script>
  </body>
</html>
