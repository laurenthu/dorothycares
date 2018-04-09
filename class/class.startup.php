<?php

class Startup {

  public $db;

  function __construct($db) {
    $this->db = $db;
  }

  function getStartupInformation($id) {
    /*
    (IN) $id(int): id of the startup for which we want to collect the data
    (OUT) array with information / false if no startup was found
    */

    $data = array();

    try {

      $statement = $this->db->prepare(
        "SELECT
        `C`.`nameClasse` as `nameStartup`,
        `I`.`idImplantation`,
        `I`.`nameimplantation`

        FROM `classe` as `C`
        LEFT JOIN `classeImplantationRelation` as `CIR` ON `C`.`idClasse` = `CIR`.`idClasse`
        LEFT JOIN `implantation` as `I` on `CIR`.`idImplantation` = `I`.`idImplantation`

        WHERE `C`.`idClasse` = :idStartup

        LIMIT 0,1");
      $statement->bindParam(':idStartup', $id, PDO::PARAM_INT);
      $statement->execute();

      if( $statement->rowCount() ) {

        //$tmp = $statement->fetch(PDO::FETCH_ASSOC);
        $data = $statement->fetch(PDO::FETCH_ASSOC);

        $statement = null;
        $statement = $this->db->prepare(
          "SELECT
          `O`.`keyOption` as `type`,
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

  function getStartupList($start = 0, $number = 25, $orderBy = 'nameClasse', $orderDir = 'ASC') {
    /*
    (IN) $id(int): id of the startup for which we want to collect the data
    (OUT) array with information / false if no startup was found
    */

    try {

      $data = array();
      $statement = $this->db->prepare(
        "SELECT
        `C`.`idClasse` as `id`,
        `C`.`nameClasse` as `name`,
        `I`.`idImplantation`,
        `I`.`nameimplantation`

        FROM `classe` as `C`
        LEFT JOIN `classeImplantationRelation` as `CIR` ON `C`.`idClasse` = `CIR`.`idClasse`
        LEFT JOIN `implantation` as `I` on `CIR`.`idImplantation` = `I`.`idImplantation`

        ORDER BY  `C`.`".$orderBy."` ".$orderDir."

        LIMIT ".$start.",".$number);
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
