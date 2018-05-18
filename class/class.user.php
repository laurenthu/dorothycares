<?php

class User {

  // protected $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public function hasAuthorizedAccess($emailUser) {
    /*
    (IN) $emailUser: email of the user we want to test
    (OUT) boolean: True if the user can access / false if not
    */

    try {

      $statement = $this->db->prepare("SELECT emailUser FROM user WHERE emailUser = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()){
        return true;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function hasAdminRights($emailUser) {
    /*
    (IN) $emailUser: email of the user we want to test
    (OUT) boolean: True if the user has admin rights / false if not
    */

    try {

      $statement = $this->db->prepare("SELECT emailUser, typeUser FROM user WHERE emailUser = :emailUser AND (typeUser LIKE 'coach' OR typeUser LIKE 'staff') LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        return true;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function getUserId($emailUser) {
    /*
    (IN) $emailUser: email of the user for which we want to collect the data
    (OUT) string if a data is found, NULL if a data is found but empty, false if no user was found
    */

    try {

      $statement = $this->db->prepare("SELECT `idUser` as `information` FROM `user` WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return intval($data['information']);
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function getUserFirstName($emailUser) {
    /*
    (IN) $emailUser: email of the user for which we want to collect the data
    (OUT) string if a data is found, NULL if a data is found but empty, false if no user was found
    */

    try {

      $statement = $this->db->prepare("SELECT `firstNameUser` as `information` FROM `user` WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function updateUserFirstName($emailUser,$firstName) {
    /*
    (IN) email of the user to check and the value to update
    (OUT) value if value was well stored / false if was not stored
    */

    try {

      $statement = $this->db->prepare("UPDATE `user` SET `firstNameUser` = :firstName WHERE `emailUser` = :emailUser");
      $statement->bindParam(':firstName', $firstName, PDO::PARAM_STR);
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      return $firstName;

    } catch (PDOException $e) {
      //print "Error !: " . $e->getMessage() . "<br/>";
      //die();
      return false;
    }

  }

  public function updateUserFirstNameById($idUser,$firstName) {
    /*
    (IN) [INT] idUser: id of the user
    (IN) [STRING] firstName: new value of the data
    (OUT) value if value was well stored / false if was not stored
    */

    try {

      $statement = $this->db->prepare("UPDATE `user` SET `firstNameUser` = :firstName WHERE `idUser` = :idUser");
      $statement->bindParam(':firstName', $firstName, PDO::PARAM_STR);
      $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
      $statement->execute();

      return $firstName;

    } catch (PDOException $e) {
      //print "Error !: " . $e->getMessage() . "<br/>";
      //die();
      return false;
    }

  }

  public function getUserLastName($emailUser) {
    /*
    (IN) $emailUser: email of the user for which we want to collect the data
    (OUT) string if a data is found, NULL if a data is found but empty, false if no user was found
    */

    try {

      $statement = $this->db->prepare("SELECT `lastNameUser` as `information` FROM `user` WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function updateUserLastName($emailUser,$lastName) {
    /*
    (IN) [INT] emailUser: id of the user
    (IN) [STRING] lastName: new value of the data
    (OUT) value if value was well stored / false if was not stored
    */

    try {

      $statement = $this->db->prepare("UPDATE `user` SET `lastNameUser` = :lastName WHERE `emailUser` = :emailUser");
      $statement->bindParam(':lastName', $lastName, PDO::PARAM_STR);
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      return $lastName;

    } catch (PDOException $e) {
      //print "Error !: " . $e->getMessage() . "<br/>";
      //die();
      return false;
    }

  }

  public function updateUserLastNameById($idUser,$lastName) {
    /*
    (IN) [INT] idUser: id of the user
    (IN) [STRING] lastName: new value of the data
    (OUT) value if value was well stored / false if was not stored
    */

    try {

      $statement = $this->db->prepare("UPDATE `user` SET `lastNameUser` = :lastName WHERE `idUser` = :idUser");
      $statement->bindParam(':lastName', $lastName, PDO::PARAM_STR);
      $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
      $statement->execute();

      return $lastName;

    } catch (PDOException $e) {
      //print "Error !: " . $e->getMessage() . "<br/>";
      //die();
      return false;
    }

  }

  public function getUserMainLanguageCode($emailUser) {
    /*
    (IN) $emailUser: email of the user for which we want to collect the data
    (OUT) string if a data is found, false if no user was found
    */

    try {

      $statement = $this->db->prepare("SELECT `mainLanguageUser` as `information` FROM `user` WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function updateUserMainLanguageCode($emailUser,$languageCode) {
    /*
    (IN) [INT] emailUser: email of the user
    (IN) [STRING] languageCode: new value of the data
    (OUT) value if value was well stored / false if was not stored
    */

    try {

      $statement = $this->db->prepare("UPDATE `user` SET `mainLanguageUser` = :languageCode WHERE `emailUser` = :emailUser");
      $statement->bindParam(':languageCode', $languageCode, PDO::PARAM_STR);
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();
      return $languageCode;

    } catch (PDOException $e) {
      //print "Error !: " . $e->getMessage() . "<br/>";
      //die();
      return false;
    }

  }

  public function updateUserMainLanguageCodeById($idUser,$languageCode) {
    /*
    (IN) [INT] idUser: id of the user
    (IN) [STRING] languageCode: new value of the data
    (OUT) value if value was well stored / false if was not stored
    */

    try {

      $statement = $this->db->prepare("UPDATE `user` SET `mainLanguageUser` = :languageCode WHERE `idUser` = :idUser");
      $statement->bindParam(':languageCode', $languageCode, PDO::PARAM_STR);
      $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
      $statement->execute();
      return $languageCode;

    } catch (PDOException $e) {
      //print "Error !: " . $e->getMessage() . "<br/>";
      //die();
      return false;
    }

  }

  public function getUserMainLanguageName($emailUser) {
    /*
    (IN) $emailUser: email of the user for which we want to collect the data
    (OUT) string if a data is found, false if no user was found
    */

    try {

      $statement = $this->db->prepare(
        "SELECT  `L`.`nameLanguageEnglish` AS  `information`
         FROM  `user` AS  `U`
         LEFT JOIN  `language` AS  `L` ON  `U`.`mainLanguageUser` =  `L`.`codeLanguage`
         WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function getUserType($emailUser) {
    /*
    (IN) $emailUser: email of the user for which we want to collect the data
    (OUT) string if a data is found, false if no user was found
    */

    try {

      $statement = $this->db->prepare("SELECT `typeUser` as `information` FROM `user` WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function updateUserType($emailUser,$typeUser) {
    /*
    (IN) [INT] emailUser: email of the user
    (IN) [STRING] typeUser: new value of the data
    (OUT) value if value was well stored / false if was not stored
    */

    try {

      $statement = $this->db->prepare("UPDATE `user` SET `typeUser` = :typeUser WHERE `emailUser` = :emailUser");
      $statement->bindParam(':typeUser', $typeUser, PDO::PARAM_STR);
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if( $statement->rowCount() ) {
        return $typeUser;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function updateUserTypeById($idUser,$typeUser) {
    /*
    (IN) [INT] idUser: id of the user
    (IN) [STRING] typeUser: new value of the data
    (OUT) value if value was well stored / false if was not stored
    */

    try {

      $statement = $this->db->prepare("UPDATE `user` SET `typeUser` = :typeUser WHERE `idUser` = :idUser");
      $statement->bindParam(':typeUser', $typeUser, PDO::PARAM_STR);
      $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
      $statement->execute();

      if( $statement->rowCount() ) {
        return $typeUser;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function updateUserEmailById($idUser,$emailUser) {
    /*
    (IN) id of the user to check and the value to update
    (IN) new email of the user
    (OUT) value if value was well stored / false if was not stored
    */

    try {

      $statement = $this->db->prepare("UPDATE `user` SET `emailUser` = :emailUser WHERE `idUser` = :idUser");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
      $statement->execute();

      if( $statement->rowCount() ) {
        return $typeUser;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function getUserStartupName($emailUser) {
    /*
    (IN) [STRING] $emailUser: email of the user for which we want to collect the data
    (OUT) string if a data is found, false if no user was found
    */

    try {

      $statement = $this->db->prepare(
        "SELECT `C`.`nameClasse` as `information` FROM `user` as `U`
         LEFT JOIN `userClasseRelation` as `UCR` on `U`.`idUser` = `UCR`.`idUser`
         LEFT JOIN `classe` as `C` on `C`.`idClasse` = `UCR`.`idClasse`
         WHERE `U`.`emailUser` = :emailUser
         LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function getUserStartupId($emailUser) {
    /*
    (IN) [STRING] $emailUser: email of the user for which we want to collect the data
    (OUT) integer if a data is found, false if no user was found
    */

    try {

      $statement = $this->db->prepare(
        "SELECT `UCR`.`idClasse` as `information` FROM `user` as `U`
         LEFT JOIN `userClasseRelation` as `UCR` on `U`.`idUser` = `UCR`.`idUser`
         WHERE `U`.`emailUser` = :emailUser
         LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return intval($row['information']);
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function getUserImplantationName($emailUser) {
    /*
    (IN) [STRING] $emailUser: email of the user for which we want to collect the data
    (OUT) string if a data is found, false if no user was found
    */

    try {

      $statement = $this->db->prepare(
        "SELECT  `I`.`nameimplantation` AS  `information`
         FROM  `user` AS  `U`
         LEFT JOIN  `userClasseRelation` AS  `UCR` ON  `U`.`idUser` =  `UCR`.`idUser`
         LEFT JOIN  `classeImplantationRelation` AS  `CIR` ON  `CIR`.`idClasse` =  `UCR`.`idClasse`
         LEFT JOIN  `implantation` AS  `I` ON  `CIR`.`idImplantation` =  `I`.`idImplantation`
         WHERE `U`.`emailUser` = :emailUser
         LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function getUserImplantationId($emailUser) {
    /*
    (IN) [STRING] $emailUser: email of the user for which we want to collect the data
    (OUT) integer if a data is found, false if no user was found
    */

    try {

      $statement = $this->db->prepare(
        "SELECT  `CIR`.`idImplantation` AS  `information`
         FROM  `user` AS  `U`
         LEFT JOIN  `userClasseRelation` AS  `UCR` ON  `U`.`idUser` =  `UCR`.`idUser`
         LEFT JOIN  `classeImplantationRelation` AS  `CIR` ON  `CIR`.`idClasse` =  `UCR`.`idClasse`
         WHERE `U`.`emailUser` = :emailUser
         LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return intval($row['information']);
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function getUserInformation($emailUser) {
    /*
    (IN) [STRING] emailUser: the email of the user
    (OUT) an array with the data / false if not
    */

    try {

      $data = array();

      $statement = $this->db->prepare(
        "SELECT
        `U`.`idUser` as `id`,
        `U`.`firstNameUser` as `firstName`,
        `U`.`lastNameUser` as `lastName` ,
        `U`.`typeUser` as `type`,
        `U`.`mainLanguageUser` as `mainLanguageCode`,
        `L`.`nameLanguageEnglish` as `mainLanguage`

        FROM `user` as `U`
        LEFT JOIN  `language` AS  `L` ON  `U`.`mainLanguageUser` =  `L`.`codeLanguage`

        WHERE `emailUser` = :emailUser LIMIT 0,1");

      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if( $statement->rowCount() ) {

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        $data['startup']['id'] = $this->getUserStartupId($emailUser);
        $data['startup']['name'] = $this->getUserStartupName($emailUser);
        $data['implantation']['id'] = $this->getUserImplantationId($emailUser);
        $data['implantation']['name'] = $this->getUserImplantationName($emailUser);

        $statement = null;

        $statement = $this->db->prepare(
          "SELECT
          `O`.`keyOption` as `type`,
		      `O`.`valueOption` as `key`,
          `O`.`nameOption` as `name`,
          `UM`.`valueUserMeta` as `value`

           FROM `userMeta` as `UM`
           LEFT JOIN `option` as `O` ON `O`.`idOption` = `UM`.`idOption`

           WHERE `UM`.`idUser` = :idUser");

        $statement->bindParam(':idUser', $data['id'], PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() > 0) {
          $data['meta'] = array();
          while ( $en = $statement->fetch(PDO::FETCH_ASSOC) ) {
            array_push($data['meta'], $en);
          }
        }

        return $data;

      } else {

        return false;

      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function getUserInformationAllMeta($email) {
    /*
    (IN) [STRING] email: the email of the user
    (OUT) an array with the data / false if not
    */

    try {

      $data = array();
      $idUser = $this->getUserId($email);

      $statement = $this->db->prepare(
        "SELECT
        `O`.`idOption` as `id`,
        `O`.`keyOption` as `type`,
	      `O`.`valueOption` as `key`,
        `O`.`nameOption` as `name`,
        `UM`.`valueUserMeta` as `value`

         FROM `userMeta` as `UM`
         LEFT JOIN `option` as `O` ON `O`.`idOption` = `UM`.`idOption`

         WHERE `UM`.`idUser` = :idUser");

      $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
      $statement->execute();

      if ($statement->rowCount() > 0) {

        while ( $en = $statement->fetch(PDO::FETCH_ASSOC) ) {
          array_push($data, $en);
        }

        return $data;

      } else {

        return false;

      }

    } catch (PDOException $e) {

      print "Error !: " . $e->getMessage() . "<br/>";
      die();

    }

  }

  public function getUserInformationOneMeta($email, $key) {
    /*
    (IN) [STRING] email: the email of the user
    (IN) [STRING] key: the key of the meta we want to collect
    (OUT) the data / false if not
    */

    try {

      $data = array();
      $idUser = $this->getUserId($email);

      $statement = $this->db->prepare(
        "SELECT
        `O`.`idOption` as `id`,
        `O`.`keyOption` as `type`,
	      `O`.`valueOption` as `key`,
        `O`.`nameOption` as `name`,
        `UM`.`valueUserMeta` as `value`

         FROM `userMeta` as `UM`
         LEFT JOIN `option` as `O` ON `O`.`idOption` = `UM`.`idOption`

         WHERE `UM`.`idUser` = :idUser AND `O`.`valueOption` LIKE :key");

      $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
      $statement->bindParam(':key', $key, PDO::PARAM_STR);
      $statement->execute();

      if ($statement->rowCount() > 0) {

        return $statement->fetch(PDO::FETCH_ASSOC);

      } else {

        return false;

      }

    } catch (PDOException $e) {

      print "Error !: " . $e->getMessage() . "<br/>";
      die();

    }

  }

  public function getUserCount() {
    /*
    (OUT) int with number of startup / 0 if no startup was found
    */
    try {

      $statement = $this->db->prepare("SELECT COUNT(`U`.`idUser`) as `number` FROM `user` as `U`");
      $statement->execute();

      if($statement->rowCount() > 0) {
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return intval($data['number']);
      } else {
        return 0;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function getUserList($start = 0, $number = 25, $typeUser = 'all', $orderBy = 'firstNameUser', $orderDir = 'ASC') {
    /*
    (IN) [INT] $start: start number (for pagination)
    (IN) [INT] $number; how many items (for pagination)
    (IN) [STRING] $orderBy: name of the column for the order
    (IN) [STRING] $orderDir: order ASC or DESC
    (OUT) array with information / false if no implantation was found
    */

    try {

      if ($typeUser == 'all') {
        $where = '';
      } else {
        $where = "WHERE `U`.`typeUser` =  '".$typeUser."'";
      }

      $statement = $this->db->prepare(
        "SELECT
        `U`.`idUser` as `id`,
        `U`.`firstNameUser` as `firstName`,
        `U`.`lastNameUser` as `lastName` ,
        `U`.`emailUser` as `email`,
        `U`.`typeUser` as `type`,
        `U`.`mainLanguageUser` as `mainLanguageCode`,
        `L`.`nameLanguageEnglish` as `mainLanguage`

        FROM `user` as `U`
        LEFT JOIN  `language` AS  `L` ON  `U`.`mainLanguageUser` =  `L`.`codeLanguage`

        ".$where."

        ORDER BY  `U`.`".$orderBy."` ".$orderDir."

        LIMIT ".$start.",".$number);

      $statement->execute();

      if($statement->rowCount() > 0) {
        return $statement->fetchAll(PDO::FETCH_ASSOC);
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function checkGoogleIdUser($emailUser) {
    /*
    (IN) email of the user to check
    (OUT) true is Google ID is stored / false if Google Id is NULL or no user was found
    */

    try {

      $statement = $this->db->prepare("SELECT `idGoogleUser` as `information` FROM `user` WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ( is_null($row['information']) ) {
          return false;
        } else {
          return true;
        }
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function updateGoogleIdUser($emailUser,$idGoogleUser) {
    /*
    (IN) email of the user to check
    (OUT) true is Google ID was well saved / false if was not stored
    */

    try {

      $statement = $this->db->prepare("UPDATE `user` SET `idGoogleUser` = :idGoogleUser WHERE `emailUser` = :emailUser");
      $statement->bindParam(':idGoogleUser', $idGoogleUser, PDO::PARAM_STR);
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if( $statement->rowCount() ) {
        return true;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  protected function getGoogleIdUser($emailUser) {
    /*
    (IN) email of the user to check
    (OUT) true return idGoogleUser / false if was not found
    */

    try {

      $statement = $this->db->prepare("SELECT `idGoogleUser` as `information` FROM `user` WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if( $statement->rowCount() ) {
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  protected function generationRandomPassword($length = 25) {
    /*
    (IN) [INT] $length: length of the password
    (OUT) return a random password
    */
    $signs = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $signsLength = strlen($signs) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
      $pass[] = $signs[ rand(0, $signsLength) ];
    }
    return implode($pass); //turn the array into a string
  }

  public function checkRandomSaltdUser($emailUser) {
    /*
    (IN) email of the user to check
    (OUT) true is randomSalt is stored / false if randomSalt is NULL or no user was found
    */

    try {

      $statement = $this->db->prepare("SELECT `randomSalt` as `information` FROM `user` WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ( is_null($row['information']) ) {
          return false;
        } else {
          return true;
        }
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function updateRandomSaltdUser($emailUser) {
    /*
    (IN) email of the user to check
    (OUT) true is randomSalt was well saved / false if was not stored
    */

    try {

      $randomSalt = $this->generationRandomPassword(35);

      $statement = $this->db->prepare("UPDATE `user` SET `randomSalt` = :randomSalt WHERE `emailUser` = :emailUser");
      $statement->bindParam(':randomSalt', $randomSalt, PDO::PARAM_STR);
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if( $statement->rowCount() ) {
        return true;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function deleteRandomSaltdUser($emailUser) {
    /*
    (IN) email of the user to check
    (OUT) true is randomSalt was well deleted / false if was not deleted
    */

    try {

      $statement = $this->db->prepare("UPDATE `user` SET `randomSalt` = NULL WHERE `emailUser` = :emailUser");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if( $statement->rowCount() ) {
        return true;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function getRandomSaltdUser($emailUser) {
    /*
    (IN) email of the user to check
    (OUT) true return randomSalt / false if was not found
    */

    try {

      $statement = $this->db->prepare("SELECT `randomSalt` as `information` FROM `user` WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if( $statement->rowCount() ) {
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  protected function generateUserPassword($emailUser , $randomSalt = NULL) {
    /*
    (IN) [STRING] email of the user to check
    (IN) [STRING] randomSalt to geenrate password
    (OUT) password if password was well generated / false if was not generated
    */

    $googleId = $this->getGoogleIdUser($emailUser);

    if ( is_null($randomSalt) ) {
      $randomSalt = $this->getRandomSaltdUser($emailUser);
    }

    $password = password_hash($emailUser.$googleId.$randomSalt, PASSWORD_DEFAULT);

    if( $password != false ) {
      return $password;
    } else {
      return false;
    }

  }

  public function updatePasswordUser($emailUser) {
    /*
    (IN) email of the user to check
    (OUT) password if password was well stored / false if was not stored
    */

    $passwordUser = $this->generateUserPassword($emailUser);

    try {

      $statement = $this->db->prepare("UPDATE `user` SET `passwordUser` = :passwordUser WHERE `emailUser` = :emailUser");
      $statement->bindParam(':passwordUser', $passwordUser, PDO::PARAM_STR);
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if( $statement->rowCount() ) {
        return true;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function updateSessionIdUser($emailUser,$sessionId) {
    /*
    (IN) [STRING] email of the user
    (IN) [STRING] sessionId of the user
    (OUT) true is ok, false it not
    */

    try {

      $statement = $this->db->prepare("UPDATE `user` SET `sessionIdUser` = :sessionId WHERE `emailUser` = :emailUser");
      $statement->bindParam(':sessionId', $sessionId, PDO::PARAM_STR);
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if( $statement->rowCount() ) {
        return true;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function getEmailUserBySessionIdUser($sessionId) {
    /*
    (IN) [STRING] sessionId of the user to check
    (OUT) return email if ok, false if not
    */

    try {

      $statement = $this->db->prepare("SELECT `emailUser` as `information` FROM `user` WHERE `sessionIdUser` = :sessionId LIMIT 0,1");
      $statement->bindParam(':sessionId', $sessionId, PDO::PARAM_STR);
      $statement->execute();

      if( $statement->rowCount() ) {
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function getTokenUserBySessionIdUser($sessionId) {
    /*
    (IN) [STRING] sessionId of the user to check
    (OUT) return token if ok, false if not
    */

    try {

      $statement = $this->db->prepare("SELECT `randomSalt` as `information` FROM `user` WHERE `sessionIdUser` = :sessionId LIMIT 0,1");
      $statement->bindParam(':sessionId', $sessionId, PDO::PARAM_STR);
      $statement->execute();

      if( $statement->rowCount() ) {
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  protected function getPasswordUser($emailUser) {
    /*
    (IN) [STRING] email of the user to check
    (OUT) true return passwordUser / false if was not found
    */

    try {

      $statement = $this->db->prepare("SELECT `passwordUser` as `information` FROM `user` WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if( $statement->rowCount() ) {
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function checkPassworduser($emailUser,$randomSalt) {
    /*
    (IN) [STRING] email of the user to check
    (IN) [STRING] ramdonSalt of the user to check
    (OUT)return true is password match / false if not
    */
    $hashOriginal = $this->getPasswordUser($emailUser);
    $googleId = $this->getGoogleIdUser($emailUser);
    $passwordToTest = $emailUser.$googleId.$randomSalt;

    return password_verify($passwordToTest, $hashOriginal);

  }

  public function addUserLog($emailUser) {
    /*
    (IN) [STRING] email of the user to check
    (OUT) return true is insertion was well done / false if not
    */

    try {

      $id = $this->getUserId($emailUser);
      $statement = $this->db->prepare("INSERT INTO `userLog` (`idLog`,`idUser`,`timeLog`) VALUES (NULL,:idUser, NOW())");
      $statement->bindParam(':idUser', $id, PDO::PARAM_INT);
      $statement->execute();

      if( $statement->rowCount() ) {
        return true;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function addUser($email,$startupId = false, $typeUser = 'learner',$languageCode = 'en') {
    /*
    (IN) [string] $email: of the user to check
    (IN) [integer/boolean]: $startupId. An integer with the id of the startup or false is no startup
    (IN) [string] $typeUser: type of user
    (IN) [string] $languageCode: the language of the user
    (OUT) return ID of the user is insertion was well done / false if not
    */

    try {

      $this->db->beginTransaction();

      $statement = $this->db->prepare("INSERT INTO `user` (`idUser`,`idGoogleUser`,`randomSalt`,`passwordUser`,`sessionIdUser`,`emailUser`,`firstNameUser`,`lastNameUser`,`mainLanguageUser`,`typeUser`) VALUES (NULL,NULL,NULL,NULL,NULL,:email,NULL,NULL,:languageCode,:typeUser)");
      $statement->bindParam(':email', $email, PDO::PARAM_STR);
      $statement->bindParam(':languageCode', $languageCode, PDO::PARAM_STR);
      $statement->bindParam(':typeUser', $typeUser, PDO::PARAM_STR);
      $statement->execute();

      $idUser = $this->db->lastInsertId();

      if ($startupId != false) {
        $statement = $this->db->prepare("INSERT INTO `userClasseRelation` (`idUserClasseRelation`,`idUser`,`idClasse`) VALUES (NULL,:idUser,:idStartup)");
        $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $statement->bindParam(':idStartup', $startupId, PDO::PARAM_INT);
        $statement->execute();
      }

      if( $this->db->commit() ) { // if all is ok, we validate the transaction and check the validation is good
        return $idUser; // we return the ID od the new user
      } else {
        return false;
      }

    } catch (PDOException $e) {
      $this->db->rollback();
      $statement = null;
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function addUserMeta($idUser, $idOption, $valueUserMeta) {
    /*
    (IN) [integer] idUSer: id of the user to check
    (IN) [integer] idOption id of the option
    (IN) [string] valueUserMeta: the value to store
    (OUT) true if ok / false if not
    */

    try {

      $statement = $this->db->prepare("INSERT INTO `userMeta` (`idUserMeta`,`idUser`,`idOption`,`valueUserMeta`) VALUES (NULL,:idUser,:idOption,:valueUserMeta)");
      $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
      $statement->bindParam(':idOption', $idOption, PDO::PARAM_INT);
      $statement->bindParam(':valueUserMeta', $valueUserMeta, PDO::PARAM_STR);
      $statement->execute();

      if( $statement->rowCount() ) {
        return true;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function updateUserMeta($idUser, $idOption, $valueUserMeta) {
    /*
    (IN) [integer] idUSer: id of the user to check
    (IN) [integer] idOption id of the option
    (IN) [string] valueUserMeta: the value to update
    (OUT) string with the value if ok / false if not
    */

    try {

      $statement = $this->db->prepare("UPDATE `userMeta` SET `valueUserMeta` = :valueUserMeta WHERE `idUser` = :idUser AND `idOption` = :idOption");
      $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
      $statement->bindParam(':idOption', $idOption, PDO::PARAM_INT);
      $statement->bindParam(':valueUserMeta', $valueUserMeta, PDO::PARAM_STR);
      $statement->execute();

      return $valueUserMeta;

    } catch (PDOException $e) {
      //print "Error !: " . $e->getMessage() . "<br/>";
      //die();
      return false;
    }

  }

  public function deleteUserMeta($idUser, $idOption) {
    /*
    (IN) [integer] idUSer: id of the user to check
    (IN) [integer] idOption id of the option
    (OUT) true if ok / false if not
    */

    try {

      $statement = $this->db->prepare("DELETE FROM `userMeta` WHERE `idUser` = :idUser AND `idOption` = :idOption");
      $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
      $statement->bindParam(':idOption', $idOption, PDO::PARAM_INT);
      $statement->execute();

      return true;

    } catch (PDOException $e) {
      //print "Error !: " . $e->getMessage() . "<br/>";
      //die();
      return false;
    }

  }

  public function addMultipleUser($arrayEmail,$startupId = false, $typeUser = 'learner', $languageCode = 'en') {
    /*
    (IN) [string] $arrayEmail: array of email addresses to add
    (IN) [integer/boolean]: $startupId. An integer with the id of the startup or false is no startup
    (IN) [string] $typeUser: type of user
    (IN) [string(2)] $languageCode: the language of the user
    (OUT) return email of the users were the insertion failed or true if everything is ok
    */
    $errors = [];

    foreach($arrayEmail as $key => $value) {
      if ( $this->addUser($value, $startupId, $typeUser,$languageCode) == false ) {
        array_push($errors,$value);
      }
    }

    if ( count($errors) == 0 ) {
      return true;
    } else {
      return $errors;
    }

  }

  public function deleteUser($idUser) {
    /*
    (IN) id of the implantation to delete
    (OUT) an array wuth the results.
    */

    $answer = array();
    $idUser = intval($idUser); // to be sure that is a integer (if it's valid data)

    try {

        $this->db->beginTransaction(); // we start a transaction

        // we can destroy the relation with the startup
        $statement = $this->db->prepare("DELETE FROM `userClasseRelation` WHERE `idUser` = :idUser");
        $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $statement->execute();
        
        // we delete the user
        $statement = $this->db->prepare("DELETE FROM `user` WHERE `idUser` = :idUser");
        $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $statement->execute();


        if( $this->db->commit() ) { // if everything is okay
          $answer['status'] = 'success';
          $answer['message'] = 'The user was well deleted.';
        } else {
          $answer['status'] = 'error';
          $answer['message'] = 'Sorry, an error occurred while deleting the user';
        }

      return $answer;

    } catch (PDOException $e) {

      $this->db->rollback(); // we cancel the transaction
      $answer['status'] = 'error';
      $answer['message'] = 'Error !: ' . $e->getMessage();
      return $answer;

    }

  }

}

?>
