<?php
  require_once 'srv/_config_admin.php';

  if (!isset($_SESSION['access_token'])) { // security check
    header('Location: login.php');
    exit();
  } else {
    header('Location: admin.php');
    exit();
  }

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
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css"> -->
    <link rel="stylesheet" href="css/materialize.min.css">
    <link rel="stylesheet" href="css/admin-management.css">
  </head>
  <body>

    <!-- Tabs Menu -->
    <div class="row">
      <div class="col s12">
        <ul class="tabs">
          <li id="implantationTab" class="tab col s3"><a class="active" href="#implantation" data-type="implantation">Implantation</a></li>
          <li id="startupTab" class="tab col s3"><a href="#startup" data-type="startup">Startup</a></li>
          <li id="userTab" class="tab col s3"><a href="#utilisateur" data-type="user">User</a></li>
        </ul>
      </div>

      <!-- Implantation Tab -->
      <div id="implantation" class="col s12">

        <!-- Pagination -->
        <ul class="pagination implantationPage" data-itemPerPage="<?php echo  $iNumberResults ?>" data-type="implantation">
          <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
          <li class="active" data-start="0"><a href="#!">1</a></li>
          <?php
          if ($iPageCount > 1) { // if there are more than 1 page of results to display
            for ($i = 2, $start = $iNumberResults; $i <= $iPageCount; $i++, $start += $iNumberResults) { // create the pagination elements for the pages
              echo '<li class="waves-effect" data-start="' . $start . '"><a href="#!">' . $i . '</a></li>';
            };
          };
          ?>
          <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul>

        <!-- Implantation Table -->
        <table class="responsive-table">

          <thead>
            <tr>
              <th>Name</th>
              <th>Address</th>
              <th>Postal Code</th>
              <th>City</th>
              <th>Country</th>
              <th></th>
            </tr>
          </thead>

          <tbody id="implantationTable">
            <!-- Table body created with ajax request -->
          </tbody>

        </table>

        <!-- Add button -->
        <div class="addButtonContainer" data-type="implantation">
          <a href="#implantationAddModal" id="implantationModalButton" class="btn-floating btn-large waves-effect waves-light red modal-trigger"><i class="material-icons">add</i></a>
        </div>

      </div>

      <!-- Startup Tab -->
      <div id="startup" class="col s12">

        <!-- Pagination -->
        <ul class="pagination startupPage" data-itemPerPage="<?php echo  $sNumberResults ?>" data-type="startup">
          <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
          <li class="active" data-start="0"><a href="#!">1</a></li>
          <?php
          if ($sPageCount > 1) { // if there are more than 1 page of results to display
            for ($i = 2, $start = $sNumberResults; $i <= $sPageCount; $i++, $start += $sNumberResults) { // create the pagination elements for the pages
              echo '<li class="waves-effect" data-start="' . $start . '"><a href="#!">' . $i . '</a></li>';
            };
          };
          ?>
          <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul>

        <!-- Startup Table -->
        <table class="responsive-table">

          <thead>
            <tr>
              <th>Name</th>
              <th></th>
            </tr>
          </thead>

          <tbody id="startupTable">
            <!-- Table body created with ajax request -->
          </tbody>

        </table>

        <!-- Add button -->
        <div class="addButtonContainer" data-type="startup">
          <a href="#startupAddModal" id="startupModalButton" class="btn-floating btn-large waves-effect waves-light red modal-trigger"><i class="material-icons">add</i></a>
        </div>

      </div>

      <!-- User Tab -->
      <div id="utilisateur" class="col s12">

        <!-- Pagination -->
        <ul class="pagination userPage" data-itemPerPage="<?php echo  $uNumberResults ?>" data-type="user">
          <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
          <li class="active" data-start="0"><a href="#!">1</a></li>
          <?php
          if ($uPageCount > 1) { // if there are more than 1 page of results to display
            for ($i = 2, $start = $uNumberResults; $i <= $uPageCount; $i++, $start += $uNumberResults) { // create the pagination elements for the pages
              echo '<li class="waves-effect" data-start="' . $start . '"><a href="#!">' . $i . '</a></li>';
            };
          };
          ?>
          <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul>

        <!-- User Table -->
        <table class="responsive-table">

          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Mail</th>
              <th>Type</th>
              <th>Language</th>
              <th></th>
            </tr>
          </thead>

          <tbody id="userTable">
            <!-- Table body created with ajax request -->
          </tbody>

        </table>

        <!-- Add button -->
        <div class="addButtonContainer" data-type="user">
          <a href="#userAddModal" id="userModalButton" class="btn-floating btn-large waves-effect waves-light red modal-trigger"><i class="material-icons">add</i></a>
        </div>

      </div>

   </div>

   <!-- Modals opened by the buttons for adding data -->
   <div id="implantationAddModal" class="modal">
    <div class="modal-content">
      <h4>Add an implantation</h4>
      <div class="row">
        <form class="col s12">
          <div class="row">
            <div class="input-field col s4">
              <input class="validate" type="text" name="nameImplantation" id="nameImplantation" required>
              <label for="nameImplantation">Name</label>
            </div>
            <div class="input-field col s8">
              <input class="validate" type="text" name="streetImplantation" id="streetImplantation" required>
              <label for="streetImplantation">Address</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s4">
              <input class="validate" type="number" name="postalCodeImplantation" id="postalCodeImplantation" required>
              <label for="postalCodeImplantation">Postal Code</label>
            </div>
            <div class="input-field col s4">
              <input class="validate" type="text" name="cityImplantation" id="cityImplantation" required>
              <label for="cityImplantation">City</label>
            </div>
            <div class="input-field col s4">
              <select id="countryImplantation" required>
                <option value="" disabled selected>Choose your option</option>
                <?php
                  $countryList = (new System($db))->getCountryList(); // get the options from the database
                  foreach ($countryList as $value) { // create the options for the select
                    echo '<option value="' . $value['value'] . '">' . $value['name'] . '</option>';
                  }
                ?>
              </select>
              <label>Country</label>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" id="addImplantation" class="modal-action modal-close waves-effect waves-green btn-flat" data-type="implantation">Add</a>
    </div>
  </div>

  <div id="startupAddModal" class="modal">
   <div class="modal-content">
     <h4>Add a startup</h4>
     <div class="row">
       <form class="col s12">
         <div class="row">
           <div class="input-field col s6">
             <input class="validate" type="text" name="nameStartup" id="nameStartup" required>
             <label for="nameStartup">Name</label>
           </div>
           <div class="input-field col s6">
             <select id="linkedImplantation" required>
               <option value="" disabled selected>Choose your option</option>
               <?php
                 $implantationList = (new Implantation($db))->getImplantationList(); // get the options from the database
                 foreach ($implantationList as $value) { // create the options for the select
                   echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                 }
               ?>
             </select>
             <label>Implantation</label>
           </div>
         </div>
         <div class="row">
           <div class="input-field col s12">
             <textarea id="addLinkedLearners" class="validate materialize-textarea"></textarea>
             <label for="addLinkedLearners">Learner(s) to add (optional)</label>
           </div>
         </div>
       </form>
     </div>
   </div>
   <div class="modal-footer">
     <a href="#!" id="addStartup" class="modal-action modal-close waves-effect waves-green btn-flat" data-type="startup">Add</a>
   </div>
 </div>

 <div id="userAddModal" class="modal">
  <div class="modal-content">
    <h4>Add user(s)</h4>
    <div class="row">
      <form class="col s12">
        <div class="row">
          <div class="input-field col s8">
            <textarea id="addUsers" class="validate materialize-textarea" required></textarea>
            <label for="addUsers">User(s) to add</label>
          </div>
          <div class="input-field col s4">
            <select id="userType" required>
              <option value="" disabled selected>Choose your option</option>
              <?php
                $typesList = (new System($db))->getOptionList('typeUser'); // get the options from the database
                foreach ($typesList as $value) { // create the options for the select
                  echo '<option value="' . $value['value'] . '">' . $value['name'] . '</option>';
                }
              ?>
            </select>
            <label>Type of the user</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s4">
            <select id="linkedStartup">
              <option value="" selected>Choose your option</option>
              <?php
                $startupsList = (new Startup($db))->getStartupList(0, 15000); // get the options from the database
                foreach ($startupsList as $value) { // create the options for the select
                  echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                }
              ?>
            </select>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" id="addUser" class="modal-action modal-close waves-effect waves-green btn-flat" data-type="user">Add</a>
  </div>
 </div>

 <div id="implantationDeleteModal" class="modal">
  <div class="modal-content">
    <h4>Delete Implantation</h4>
    <div class="row">
      <div class="col s4">
        <h5>Name</h5>
      </div>
      <div class="col s8">
        <h5  id="displayNameImplantation"></h5>
      </div>
    </div>
    <div class="row">
      <div class="col s4 offset-s8">
        <a id="implantationDeleteButton" class="waves-effect waves-light btn red modal-close">Confirm</a>
      </div>
    </div>
  </div>
 </div>

 <div id="startupDeleteModal" class="modal">
  <div class="modal-content">
    <h4>Delete Startup</h4>
    <div class="row">
      <div class="col s4">
        <h5>Name</h5>
      </div>
      <div class="col s8">
        <h5 id="displayNameStartup"  id="displayNameStartup"></h5>
      </div>
    </div>
    <div class="row">
      <div class="col s4 offset-s8">
        <a id="startupDeleteButton" class="waves-effect waves-light btn red modal-close">Confirm</a>
      </div>
    </div>
  </div>
 </div>

 <div id="userDeleteModal" class="modal">
  <div class="modal-content">
    <h4>Delete User</h4>
    <div class="row">
      <div class="col s4">
        <h5>Name</h5>
      </div>
      <div class="col s8">
        <h5  id="displayNameUser"></h5>
      </div>
    </div>
    <div class="row">
      <div class="col s4 offset-s8">
        <a id="userDeleteButton" class="waves-effect waves-light btn red modal-close">Confirm</a>
      </div>
    </div>
  </div>
 </div>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
   <script type="js/materialize.min.js"></script>
   <script src="js/admin-management.js"></script>

  </body>
</html>
