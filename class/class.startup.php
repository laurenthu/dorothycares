<?php

class Startup {

  public $db;

  function __construct($db) {
    $this->db = $db;
  }

  function getStartupInformation($id) {
    /*
    (IN) $id(int): id of the startup for which we want to collect the data
    (OUT) array with information / false if no implantation was found
    */

    $data = array();

    try {

      $statement = $this->db->prepare("SELECT `nameClasse` as `nameStartup` FROM `classe` as `C` WHERE `C`.`idClasse` = :idStartup LIMIT 0,1");
      $statement->bindParam(':idStartup', $id, PDO::PARAM_INT);
      $statement->execute();

      if( $statement->rowCount() ) {

        $tmp = $statement->fetch(PDO::FETCH_ASSOC);
        $data['nameStartup'] = $tmp['nameStartup'];

        $statement = null;
        $statement = $this->db->prepare(
          "SELECT
          `CM`.`keyClasseMeta` as `key`,
          `O`.`nameOption` as `name`,
          `CM`.`valueClasseMeta` as `value`

           FROM `classeMeta` as `CM`
           LEFT JOIN `option` as `O` ON `O`.`valueOption` = `CM`.`keyClasseMeta`

           WHERE `CM`.`idClasse` = :idStartup");
        $statement->bindParam(':idStartup', $id, PDO::PARAM_INT);
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

}


?>
