<?php

class System {

  // protected $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public function getOptionList($type, $orderBy = 'nameOption', $orderDir = 'ASC') {

    try {

      $data = array();

      $statement = $this->db->prepare(
        "SELECT
        `O`.`valueOption` as `value`,
        `O`.`nameOption` as `name`

        FROM `option` as `O`

        WHERE `O`.`keyOption` = :typeOption

        ORDER BY  `O`.`".$orderBy."` ".$orderDir);

      $statement->bindParam(':typeOption', $type, PDO::PARAM_STR);
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

  public function getLanguageList($orderBy = 'nameLanguageEnglish', $orderDir = 'ASC') {

    try {

      $statement = $this->db->prepare(
        "SELECT
        `L`.`codeLanguage` as `value`,
        `L`.`nameLanguageEnglish` as `name`

        FROM `language` as `L`

        ORDER BY  `L`.`".$orderBy."` ".$orderDir);

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

  public function getCountryList($orderBy = 'nameCountryEnglish', $orderDir = 'ASC') {

    try {

      $statement = $this->db->prepare(
        "SELECT
        `C`.`codeCountry` as `value`,
        `C`.`nameCountryEnglish` as `name`

        FROM `country` as `C`

        ORDER BY  `C`.`".$orderBy."` ".$orderDir);

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

}

?>
