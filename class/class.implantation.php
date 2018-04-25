<?php

class Implantation {

  // protected $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public function getImplantationInformation($id) {
    /*
    (IN) $id(int): id of the implantation for which we want to collect the data
    (OUT) array with information / false if no implantation was found
    */

    try {

      $statement = $this->db->prepare(
        "SELECT
        `I`.`idImplantation` as `id`,
        `I`.`nameimplantation` as `name`,
        `I`.`streetimplantation` as `street`,
        `I`.`postalCodeimplantation` as `postalCode`,
        `I`.`cityimplantation` as `city`,
        `C`.`nameCountryEnglish` as `country`,
        `I`.`countryCodeimplantation` as `codeCountry`

        FROM `implantation` as `I`
        LEFT JOIN `country` as `C` ON `I`.`countryCodeimplantation` = `C`.`codeCountry`

        WHERE idImplantation = :idImplantation

        LIMIT 0,1");

      $statement->bindParam(':idImplantation', $id, PDO::PARAM_INT);
      $statement->execute();

      if($statement->rowCount()){
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  public function getImplantationCount() {
    /*
    (OUT) int with number of implantation / 0 if no implantation was found
    */
    try {

      $statement = $this->db->prepare("SELECT COUNT(`I`.`idImplantation`) as `number` FROM `implantation` as `I`");
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

  public function getImplantationList($start = 0, $number = 25, $orderBy = 'nameimplantation', $orderDir = 'ASC') {

    try {

      $statement = $this->db->prepare(
        "SELECT
        `I`.`idImplantation` as `id`,
        `I`.`nameimplantation` as `name`,
        `I`.`streetimplantation` as `street`,
        `I`.`postalCodeimplantation` as `postalCode`,
        `I`.`cityimplantation` as `city`,
        `C`.`nameCountryEnglish` as `country`,
        `I`.`countryCodeimplantation` as `codeCountry`

        FROM `implantation` as `I`
        LEFT JOIN `country` as `C` ON `I`.`countryCodeimplantation` = `C`.`codeCountry`

        ORDER BY  `I`.`".$orderBy."` ".$orderDir."

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

  public function updateImplantationName($id,$value) {
    /*
    (IN) [INTEGER] id of the implantation to update
    (IN) [STRING] new value for the update
    (OUT) value if value was well updated / false if not
    */

    try {

      $statement = $this->db->prepare("UPDATE `implantation` SET `nameimplantation` = :value WHERE `idImplantation` = :id");
      $statement->bindParam(':value', $value, PDO::PARAM_STR);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->execute();

      return $value;

    } catch (PDOException $e) {

      return false;

    }

  }

  public function updateImplantationStreet($id,$value) {
    /*
    (IN) [INTEGER]id of the implantation to update
    (IN) [STRING] new value for the update
    (OUT) value if value was well updated / false if not
    */

    try {

      $statement = $this->db->prepare("UPDATE `implantation` SET `streetimplantation` = :value WHERE `idImplantation` = :id");
      $statement->bindParam(':value', $value, PDO::PARAM_STR);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->execute();

      return $value;

    } catch (PDOException $e) {

      return false;

    }

  }

  public function updateImplantationPostalCode($id,$value) {
    /*
    (IN) [INTEGER] id of the implantation to update
    (IN) [INTEGER] new value for the update
    (OUT) value if value was well updated / false if not
    */

    try {

      $statement = $this->db->prepare("UPDATE `implantation` SET `postalCodeimplantation` = :value WHERE `idImplantation` = :id");
      $statement->bindParam(':value', $value, PDO::PARAM_INT);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->execute();

      return $value;

    } catch (PDOException $e) {

      return false;

    }

  }

  public function updateImplantationCity($id,$value) {
    /*
    (IN) [INTEGER] id of the implantation to update
    (IN) [STRING] new value for the update
    (OUT) value if value was well updated / false if not
    */

    try {

      $statement = $this->db->prepare("UPDATE `implantation` SET `cityimplantation` = :value WHERE `idImplantation` = :id");
      $statement->bindParam(':value', $value, PDO::PARAM_STR);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->execute();

      return $value;

    } catch (PDOException $e) {

      return false;

    }

  }

  public function updateImplantationCountry($id,$value) {
    /*
    (IN) [INTEGER] id of the implantation to update
    (IN) [STRING] new value for the update
    (OUT) value if value was well updated / false if not
    */

    try {

      $statement = $this->db->prepare("UPDATE `implantation` SET `countryCodeimplantation` = :value WHERE `idImplantation` = :id");
      $statement->bindParam(':value', $value, PDO::PARAM_STR);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->execute();

      return $value;

    } catch (PDOException $e) {

      return false;

    }

  }

  public function addImplantation($name,$street = NULL, $postalCode = NULL, $city = NULL, $countryCode = NULL) {
    /*
    (IN) email of the user to check
    (OUT) return last id is insertion was well done / false if not
    */

    try {

      $statement = $this->db->prepare("INSERT INTO `implantation` (`idImplantation`,`nameimplantation`,`streetimplantation`,`postalCodeimplantation`,`cityimplantation`,`countryCodeimplantation`) VALUES (NULL,:name,:street,:postalCode,:city,:countryCode)");
      $statement->bindParam(':name', $name, PDO::PARAM_STR);
      $statement->bindParam(':street', $street, PDO::PARAM_STR);
      $statement->bindParam(':postalCode', $postalCode, PDO::PARAM_STR);
      $statement->bindParam(':city', $city, PDO::PARAM_STR);
      $statement->bindParam(':countryCode', $countryCode, PDO::PARAM_STR);
      $statement->execute();

      if( $statement->rowCount() ) {
        return $this->db->lastInsertId();
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

}

?>
