<?php
  require_once "../srv/_config_admin.php";

  // if (!isset($_SESSION['access_token'])) {
  //   header('Location: login.php');
  //   exit();
  // } else {
  //   header('Location: admin.php');
  //   exit();
  // }

  $i = new Implantation($db);
  $iCount = $i->getImplantationCount(); // number of implantations
  $iNumberResults = 1; // you can change the number of results displayed here
  $iPageCount = ceil($iCount / $iNumberResults); // number of pages for the pagination
  $iStartList = $i->getImplantationList(0, $iNumberResults, 'nameimplantation', 'ASC'); // results showed on the first page

  $getClasse = $db->prepare("SELECT * FROM classe");
  $getClasse->execute();

  $getUser = $db->prepare("SELECT * FROM user");
  $getUser->execute();
// ?>

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
          <li class="tab col s3"><a class="active" href="#implantation">Implantation</a></li>
          <li class="tab col s3"><a href="#startup">Startup</a></li>
          <li class="tab col s3"><a href="#utilisateur">Utilisateur</a></li>
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
              <th>Code pays</th>
            </tr>
          </thead>

          <tbody id="displayTable">
            <?php
            foreach ($iStartList as $value) {
              echo '<tr>
                      <td>'.
                        $value['name']
                      . '</td>
                      <td>'.
                        $value['street']
                      . '</td>
                      <td>'.
                        $value['postalCode']
                      . '</td>
                      <td>'.
                        $value['city']
                      . '</td>
                      <td>'.
                        $value['country']
                      . '</td>
                      <td>'.
                        $value['codeCountry']
                      . '</td>
                    </tr>';
            }
            ?>
          </tbody>

        </table>

        <ul class="pagination implantationPage">
          <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
          <li class="active"><a href="#!">1</a></li>
          <?php
            if ($iPageCount > 1) {
              for ($i = 2; $i <= $iPageCount; $i++) {
                echo '<li class="waves-effect"><a href="#!">' . $i . '</a></li>';
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

          <tbody>
            <?php
            while ($row = $getClasse->fetch(PDO::FETCH_ASSOC)) {
              echo '<tr>
                      <td>'.
                        $row['nameClasse']
                      . '</td>
                    </tr>';
            }
            ?>
          </tbody>

        </table>
        <ul class="pagination classePage">
          <li class="disabled"><a href="#"><i class="material-icons">chevron_left</i></a></li>
          <li class="active"><a href="#">1</a></li>
          <li class="waves-effect"><a href="#">2</a></li>
          <li class="waves-effect"><a href="#"><i class="material-icons">chevron_right</i></a></li>
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

          <tbody>
            <?php
            while ($row = $getUser->fetch(PDO::FETCH_ASSOC)) {
              echo '<tr>
                      <td>'.
                        $row['firstNameUser']
                      . '</td>
                      <td>'.
                        $row['lastNameUser']
                      . '</td>
                      <td>'.
                        $row['emailUser']
                      . '</td>
                      <td>'.
                        $row['typeUser']
                      . '</td>
                      <td>'.
                        $row['mainLanguageUser']
                      . '</td>
                    </tr>';
            }
            ?>
          </tbody>

        </table>

        <ul class="pagination userPage">
          <li class="disabled"><a href="#"><i class="material-icons">chevron_left</i></a></li>
          <li class="active"><a href="#">1</a></li>
          <li class="waves-effect"><a href="#">2</a></li>
          <li class="waves-effect"><a href="#"><i class="material-icons">chevron_right</i></a></li>
        </ul>

      </div>

   </div>

   <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
   <script src="js/admin.js"></script>
  </body>
</html>
