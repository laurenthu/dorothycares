<?php
  require_once "../srv/_config_admin.php";
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
  </head>
  <body>

    <?php
    $getImplantation = $db->prepare("SELECT * FROM implantation");
    $getImplantation->execute();
    ?>

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

          <tbody>
            <?php
            while ($row = $getImplantation->fetch(PDO::FETCH_ASSOC)) {
              echo '<tr>
                      <td>'.
                        $row['nameimplantation']
                      . '</td>
                      <td>'.
                        $row['streetimplantation']
                      . '</td>
                      <td>'.
                        $row['postalCodeimplantation']
                      . '</td>
                      <td>'.
                        $row['cityimplantation']
                      . '</td>
                      <td>'.
                        $row['countryCodeimplantation']
                      . '</td>
                    </tr>';
            }
            ?>
          </tbody>

        </table>
      </div>
      <div id="startup" class="col s12">
        <?php  echo 'hello'; ?>
      </div>
      <div id="utilisateur" class="col s12">
        <?php echo 'hello'; ?>
      </div>
   </div>

   <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
   <script src="js/admin.js"></script>
  </body>
</html>
