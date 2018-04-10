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

}

?>
