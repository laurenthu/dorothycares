<?php
  require_once "../srv/_config_admin.php";

  $json = [];
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json');

// Add, Update or Delete data from database
if (isset($_GET['action']) && is_string($_GET['action'])) { // security checks

  if ($_GET['action'] == 'add') { // determine type of action

    if (isset($_GET['type']) && is_string($_GET['type'])) { // Security checks

      if ($_GET['type'] == 'implantation') { // determine type of data

        if (
          isset($_GET['name']) && is_string($_GET['name'])
          && isset($_GET['street']) && is_string($_GET['street'])
          && isset($_GET['postalCode']) && is_int(intval($_GET['postalCode']))
          && isset($_GET['city']) && is_string($_GET['city'])
          && isset($_GET['countryCode']) && is_string($_GET['countryCode'])) { // security checks

            $addimp = new Implantation($db);
            $json['request']['status'] = 'success';
            $json['request']['message'] = 'Data added.';
            $addimp->addImplantation($_GET['name'], $_GET['street'], $_GET['postalCode'], $_GET['city'], $_GET['countryCode']); // adds a new implantation with the data provided
            echo json_encode($json);
            die(); // we kill the script
        }
      } elseif ($_GET['type'] == 'startup') { // determine type of data

        if (
          isset($_GET['name']) && is_string($_GET['name'])
          && isset($_GET['implantationId']) && is_int(intval($_GET['implantationId']))
          && isset($_GET['addLinkedLearners']) && is_string($_GET['addLinkedLearners'])) { // security checks

            $addsta = new Startup($db);
            $json['request']['status'] = 'success';
            $json['request']['message'] = 'Data added.';
            $addsta->addStartup($_GET['name']); // adds a new startup with the data provided
            echo json_encode($json);
            die(); // we kill the script
        }
      }
    }
  }
}

// return info from database for the display
if (isset($_GET['type']) && is_string($_GET['type'])) { // Security checks

  if ($_GET['type'] == 'implantation') { // Determine type of content

    if (isset($_GET['start']) && is_int(intval($_GET['start'])) && isset($_GET['itemPerPage']) && is_int(intval($_GET['itemPerPage']))) { // Security checks
      $imp = new Implantation($db);
      $impCount = $imp->getImplantationCount(); // number of implantations
      $impPageCount = ceil($impCount / $_GET['itemPerPage']); // number of pages for the pagination
      $json['request']['status'] = 'success';
      $json['request']['message'] = 'Congrats. You have all the requested information.';
      $json['response'] = $imp->getImplantationList($_GET['start'], $_GET['itemPerPage'], 'nameimplantation', 'ASC'); // results showed on the page
      echo json_encode($json);
      die(); // we kill the script
    } else {
      $json['request']['status'] = 'error';
      $json['request']['message'] = 'Sorry you can\'t access to this page without the right parameters';
      echo json_encode($json);
      die(); // we kill the script
    }

  } elseif ($_GET['type'] == 'startup') { // Determine type of content

    if (isset($_GET['start']) && is_int(intval($_GET['start'])) && isset($_GET['itemPerPage']) && is_int(intval($_GET['itemPerPage']))) { // Security checks
      $sta = new Startup($db);
      $staCount = $sta->getStartupCount(); // number of implantations
      $staPageCount = ceil($staCount / $_GET['itemPerPage']); // number of pages for the pagination
      $json['request']['status'] = 'success';
      $json['request']['message'] = 'Congrats. You have all the requested information.';
      $json['response'] = $sta->getStartupList($_GET['start'], $_GET['itemPerPage'], 'nameClasse', 'ASC'); // results showed on the page
      echo json_encode($json);
      die(); // we kill the script
    } else {
      $json['request']['status'] = 'error';
      $json['request']['message'] = 'Sorry you can\'t access to this page without the right parameters';
      echo json_encode($json);
      die(); // we kill the script
    }

  } elseif ($_GET['type'] == 'user') { // Determine type of content

    if (isset($_GET['start']) && is_int(intval($_GET['start'])) && isset($_GET['itemPerPage']) && is_int(intval($_GET['itemPerPage']))) { // Security checks
      $use = new User($db);
      $useCount = $use->getUserCount(); // number of implantations
      $usePageCount = ceil($useCount / $_GET['itemPerPage']); // number of pages for the pagination
      $json['request']['status'] = 'success';
      $json['request']['message'] = 'Congrats. You have all the requested information.';
      $json['response'] = $use->getUserList($_GET['start'], $_GET['itemPerPage'], 'all', 'firstNameUser', 'ASC'); // results showed on the page
      echo json_encode($json);
      die(); // we kill the script
    } else {
      $json['request']['status'] = 'error';
      $json['request']['message'] = 'Sorry you can\'t access to this page without the right parameters';
      echo json_encode($json);
      die(); // we kill the script
    }
  }
}

?>
