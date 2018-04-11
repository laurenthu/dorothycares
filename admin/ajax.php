<?php
  require_once "../srv/_config_admin.php";

  $json = [];
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json');

if (isset($_GET['type']) && is_string($_GET['type'])) {

  if ($_GET['type'] == 'implantation') {

    if (isset($_GET['start']) && is_int(intval($_GET['start'])) && isset($_GET['itemPerPage']) && is_int(intval($_GET['itemPerPage']))) {
      $imp = new Implantation($db);
      $impCount = $imp->getImplantationCount(); // number of implantations
      $impPageCount = ceil($impCount / $_GET['itemPerPage']); // number of pages for the pagination
      $json['request']['status'] = 'success';
      $json['request']['message'] = 'Congrats. You have all the requested information.';
      $json['response'] = $imp->getImplantationList($_GET['start'], $_GET['itemPerPage'], 'nameimplantation', 'ASC'); // results showed on the first page
      echo json_encode($json);
      die(); // we kill the script
    } else {
      $json['request']['status'] = 'error';
      $json['request']['message'] = 'Sorry you can\'t access to this page without the right parameters';
      echo json_encode($json);
      die(); // we kill the script
    }

  } elseif ($_GET['type'] == 'startup') {

    if (isset($_GET['start']) && is_int(intval($_GET['start'])) && isset($_GET['itemPerPage']) && is_int(intval($_GET['itemPerPage']))) {
      $sta = new Startup($db);
      $staCount = $sta->getStartupCount(); // number of implantations
      $staPageCount = ceil($staCount / $_GET['itemPerPage']); // number of pages for the pagination
      $json['request']['status'] = 'success';
      $json['request']['message'] = 'Congrats. You have all the requested information.';
      $json['response'] = $sta->getStartupList($_GET['start'], $_GET['itemPerPage'], 'nameClasse', 'ASC'); // results showed on the first page
      echo json_encode($json);
      die(); // we kill the script
    } else {
      $json['request']['status'] = 'error';
      $json['request']['message'] = 'Sorry you can\'t access to this page without the right parameters';
      echo json_encode($json);
      die(); // we kill the script
    }

  } elseif ($_GET['type'] == 'user') {

    if (isset($_GET['start']) && is_int(intval($_GET['start'])) && isset($_GET['itemPerPage']) && is_int(intval($_GET['itemPerPage']))) {
      $use = new User($db);
      $useCount = $use->getUserCount(); // number of implantations
      $usePageCount = ceil($useCount / $_GET['itemPerPage']); // number of pages for the pagination
      $json['request']['status'] = 'success';
      $json['request']['message'] = 'Congrats. You have all the requested information.';
      $json['response'] = $use->getUserList($_GET['start'], $_GET['itemPerPage'], 'all', 'firstNameUser', 'ASC'); // results showed on the first page
      echo json_encode($json);
      die(); // we kill the script
    } else {
      $json['request']['status'] = 'error';
      $json['request']['message'] = 'Sorry you can\'t access to this page without the right parameters';
      echo json_encode($json);
      die(); // we kill the script
    }

  }
};
?>
