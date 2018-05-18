<?php
  require_once 'srv/_config_admin.php';

  $json = [];
  header('Access-Control-Allow-Origin: *'); // allow cross domains
  header('Content-type: application/json'); // determine the type of data transfered

function userAdding($db, $json, $usersToAdd, $idStartup = false, $typeOfUser = 'learner') { // function called when we add users
  $inputsNotAdded = []; // create an array that will contain the lines or the textarea not inserted in the user db
  $newuser = new User($db); // new instance

  foreach ($usersToAdd as $value) { // try to add users to the db with data provided in textarea
    if (filter_var($value, FILTER_VALIDATE_EMAIL) != false) { // validation
      if ($typeOfUser != 'learner') { // if the user added is not a learner
        $newuser->addUser($value, $idStartup, $typeOfUser); // we guve the type of of user as parameter
      } elseif ($idStartup != false) { // if we provide a startup id
        $newuser->addUser($value, $idStartup); // give the id as parameter
      } else {
        $newuser->addUser($value); // basic user adding
      };
    } else {
      array_push($inputsNotAdded, $value); // put the incorrect entry in an array
    };
  };

  if (count($inputsNotAdded) > 0) { // if there are incorrect entries
    $json['request']['statusMails'] = 'error';
    $json['request']['messageMails'] = strval(count($inputsNotAdded)) . ' input(s) not added : ' . implode(', ', $inputsNotAdded);
  } else {
    $json['request']['statusMails'] = 'success';
    $json['request']['messageMails'] = 'Users added';
  };

  return $json;
};

// Add, Update or Delete data from database
if (isset($_POST['action']) && is_string($_POST['action'])) { // security checks

  if ($_POST['action'] == 'add') { // determine type of action

    if (isset($_POST['type']) && is_string($_POST['type'])) { // Security checks

      if ($_POST['type'] == 'implantation') { // determine type of data

        if (
          isset($_POST['name']) && is_string($_POST['name'])
          && isset($_POST['street']) && is_string($_POST['street'])
          && isset($_POST['postalCode']) && is_int(intval($_POST['postalCode']))
          && isset($_POST['city']) && is_string($_POST['city'])
          && isset($_POST['countryCode']) && is_string($_POST['countryCode'])) { // security checks

            $addimp = new Implantation($db); // new instance
            if ($addimp->addImplantation($_POST['name'], $_POST['street'], $_POST['postalCode'], $_POST['city'], $_POST['countryCode']) == false) { // try to add a new implantation with the data provided
              $json['request']['status'] = 'error';
              $json['request']['message'] = 'Impossible to create a new implantation';
            } else {
              $json['request']['status'] = 'success';
              $json['request']['message'] = 'Implantation added.';
            };
            echo json_encode($json);
            die(); // we kill the script
        }
      } elseif ($_POST['type'] == 'startup') { // determine type of data

        if (
          isset($_POST['name']) && is_string($_POST['name'])
          && isset($_POST['implantationId']) && is_int(intval($_POST['implantationId']))
          && isset($_POST['addLinkedLearners']) && is_string($_POST['addLinkedLearners'])) { // security checks

            $usersToAdd = preg_split('/\r\n|[\r\n]/', $_POST['addLinkedLearners']); // transform text area lines into elements in an array

            $addsta = new Startup($db); // new instance
            $idStartup = $addsta->addStartup($_POST['name'], $_POST['implantationId']); // create new startup and if it works save it's Id in a variable

            if ($idStartup == false) { // if the adding failed
              $json['request']['status'] = 'error';
              $json['request']['message'] = 'Impossible to create a new startup';
            } else {
              $json['request']['status'] = 'success';
              $json['request']['message'] = 'Startup added.';
              userAdding($db, $json, $usersToAdd, intval($idStartup)); // call the function that handles the adding of users
            };


            echo json_encode($json);
            die(); // we kill the script
        }
      } elseif ($_POST['type'] == 'user') { // determine type of data

        if (isset($_POST['addUsers']) && is_string($_POST['addUsers']) && isset($_POST['typeOfUser']) && is_string($_POST['typeOfUser'])) { // security checks

          $usersToAdd = preg_split('/\r\n|[\r\n]/', $_POST['addUsers']); // transform text area lines into elements in an array
          $typeOfUser = $_POST['typeOfUser']; // save the type of user in a variable
          if ($_POST['linkedStartupId'] == '') { // check if there isn't any startup linked to the user
            $idStartup = false;
          } else {
            $idStartup = intval($_POST['linkedStartupId']); // save the Id in a variable
          }

          $json = userAdding($db, $json, $usersToAdd, $idStartup, $typeOfUser); // call the function that handles the adding of users

          echo json_encode($json);
          die(); // we kill the script
        }
      }
    }
  } elseif ($_POST['action'] == 'update') { // determine type of action

    if (
      isset($_POST['type'])
      && is_string($_POST['type'])
      && isset($_POST['fieldName'])
      && is_string($_POST['fieldName'])
      && isset($_POST['id'])
      && is_int(intval($_POST['id']))
      && isset($_POST['newValue'])
    ) { // Security checks

      if ($_POST['type'] == 'implantation') { // determine type of data

        if ($_POST['fieldName'] == 'postalCode') { // if specific field updated

          if (is_int(intval($_POST['newValue']))) { // security checks

            $updateImp = new Implantation($db); // new instance
            if ($updateImp->updateImplantationPostalCode($_POST['id'], intval($_POST['newValue'])) == false) { // if update didn't work
              $json['request']['status'] = 'error';
              $json['request']['message'] = 'Impossible to update';
            } else {
              $json['request']['status'] = 'success';
              $json['request']['message'] = 'Updated.';
            };

            echo json_encode($json);
            die(); // we kill the script
          };

        } else {

          if (is_string($_POST['newValue'])) { // security checks

            $updateImp = new Implantation($db); // new instance

            switch ($_POST['fieldName']) { // if specific field updated
              case 'name':
                if($updateImp->updateImplantationName($_POST['id'], $_POST['newValue']) == false) { // if update didn't work
                  $json['request']['status'] = 'error';
                  $json['request']['message'] = 'Impossible to update';
                } else {
                  $json['request']['status'] = 'success';
                  $json['request']['message'] = 'Updated.';
                };
                break;
              case 'street':
                if($updateImp->updateImplantationStreet($_POST['id'], $_POST['newValue']) == false) { // if update didn't work
                  $json['request']['status'] = 'error';
                  $json['request']['message'] = 'Impossible to update';
                } else {
                  $json['request']['status'] = 'success';
                  $json['request']['message'] = 'Updated.';
                };
                break;
              case 'city':
                if($updateImp->updateImplantationCity($_POST['id'], $_POST['newValue']) == false) { // if update didn't work
                  $json['request']['status'] = 'error';
                  $json['request']['message'] = 'Impossible to update';
                } else {
                  $json['request']['status'] = 'success';
                  $json['request']['message'] = 'Updated.';
                };
                break;
              case 'country':
                if($updateImp->updateImplantationCountry($_POST['id'], $_POST['newValue']) == false) { // if update didn't work
                  $json['request']['status'] = 'error';
                  $json['request']['message'] = 'Impossible to update';
                } else {
                  $json['request']['status'] = 'success';
                  $json['request']['message'] = 'Updated.';
                };
                break;

              default:
                $json['request']['status'] = 'error';
                $json['request']['message'] = 'Unknown error';
            };

            echo json_encode($json);
            die(); // we kill the script
          };
        };

      } elseif ($_POST['type'] == 'startup') { // determine type of data

        if (is_string($_POST['newValue'])) { // security checks

          $updateSta = new Startup($db); // new instance
          if($updateSta->updateStartupName($_POST['id'], $_POST['newValue']) == false) { // if update didn't work
            $json['request']['status'] = 'error';
            $json['request']['message'] = 'Impossible to update';
          } else {
            $json['request']['status'] = 'success';
            $json['request']['message'] = 'Updated.';
          };

          echo json_encode($json);
          die(); // we kill the script

        };

      } elseif ($_POST['type'] == 'user') { // determine type of data

        if (is_string($_POST['newValue'])) { // security checks

          $updateUser = new User($db); // new instance

          switch($_POST['fieldName']) { // if specific field updated
            case 'firstName':
              if ($updateUser->updateUserFirstNameById($_POST['id'], $_POST['newValue']) == false) { // if update didn't work
                $json['request']['status'] = 'error';
                $json['request']['message'] = 'Impossible to update';
              } else {
                $json['request']['status'] = 'success';
                $json['request']['message'] = 'Updated.';
              };
              break;
            case 'lastName':
              if ($updateUser->updateUserLastNameById($_POST['id'], $_POST['newValue']) == false) { // if update didn't work
                $json['request']['status'] = 'error';
                $json['request']['message'] = 'Impossible to update';
              } else {
                $json['request']['status'] = 'success';
                $json['request']['message'] = 'Updated.';
              };
              break;
            case 'userType':
              if ($updateUser->updateUserTypeById($_POST['id'], $_POST['newValue']) == false) { // if update didn't work
                $json['request']['status'] = 'error';
                $json['request']['message'] = 'Impossible to update';
              } else {
                $json['request']['status'] = 'success';
                $json['request']['message'] = 'Updated.';
              };
              break;
            case 'mainLanguage':
              if ($updateUser->updateUserMainLanguageCodeById($_POST['id'], $_POST['newValue']) == false) { // if update didn't work
                $json['request']['status'] = 'error';
                $json['request']['message'] = 'Impossible to update';
              } else {
                $json['request']['status'] = 'success';
                $json['request']['message'] = 'Updated.';
              };
              break;

            default:
              $json['request']['status'] = 'error';
              $json['request']['message'] = 'Unknown error';
          }

          echo json_encode($json);
          die(); // we kill the script

        };
      };
    };
  } elseif ($_POST['action'] == 'delete') { // determine type of action

      if (isset($_POST['type'])
      && is_string($_POST['type'])
      && isset($_POST['itemId'])
      && is_int(intval($_POST['itemId']))) { // security checks

        if ($_POST['type'] == 'implantation') { // determine data type

          $delImp = new Implantation($db); // new instance
          $resp = $delImp->deleteImplantation($_POST['itemId']);
          if ($resp['status'] == 'error') { // if delete didn't work
            $json['request']['status'] = 'error';
            $json['request']['message'] = 'Impossible to delete';
          } else {
            $json['request']['status'] = 'success';
            $json['request']['message'] = 'Implantation deleted.';
          };

          echo json_encode($json);
          die(); // we kill the script

        } elseif ($_POST['type'] == 'startup') { // determine data type

          $delSta = new Startup($db); // new instance
          $resp = $delSta->deleteStartup($_POST['itemId']);
          if ($resp['status'] == 'error') { // if delete didn't work
            $json['request']['status'] = 'error';
            $json['request']['message'] = 'Impossible to delete';
          } else {
            $json['request']['status'] = 'success';
            $json['request']['message'] = 'Startup deleted.';
          };

          echo json_encode($json);
          die(); // we kill the script

        } elseif ($_POST['type'] == 'user') { // determine data type

          $delUse = new User($db); // new instance
          $resp = $delUse->deleteUser($_POST['itemId']);
          if ($resp['status'] == 'error') { // if delete didn't work
            $json['request']['status'] = 'error';
            $json['request']['message'] = 'Impossible to delete';
          } else {
            $json['request']['status'] = 'success';
            $json['request']['message'] = 'User deleted.';
          };

          echo json_encode($json);
          die(); // we kill the script

        };
      };
  };
}

// return info from database for the display
if (isset($_GET['type']) && is_string($_GET['type'])) { // Security checks

  if ($_GET['type'] == 'implantation') { // Determine type of content

    if (isset($_GET['start']) && is_int(intval($_GET['start'])) && isset($_GET['itemPerPage']) && is_int(intval($_GET['itemPerPage']))) { // Security checks
      $imp = new Implantation($db); // new instance
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
      $sta = new Startup($db); // new instance
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
      $use = new User($db); // new instance
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

// Get options
if (isset($_GET['optionList']) && is_string($_GET['optionList'])) { // security checks
  // depending of options wanted
  if ($_GET['optionList'] == 'country') {
    $optList = new System($db); // new instance
    $json['response'] = $optList->getCountryList(); // get the options and store them in the response
  } else if ($_GET['optionList'] == 'userType') {
    $optList = new System($db); // new instance
    $json['response'] = $optList->getOptionList('typeUser'); // get the options and store them in the response
  } else if ($_GET['optionList'] == 'language') {
    $optList = new System($db); // new instance
    $json['response'] = $optList->getLanguageList(); // get the options and store them in the response
  };
  echo json_encode($json);
  die(); // we kill the script
};

// Get json web token
if (isset($_GET['dataToGet']) && is_string($_GET['dataToGet'])) { // security checks
  $json['request']['status'] = 'success';
  $json['request']['message'] = 'Congrats. You have all the requested information.';
  $json['response']['jwt'] = $_SESSION['jwt']; // store the jwt in a session variable
  echo json_encode($json);
  die(); // we kill the script
};


?>
