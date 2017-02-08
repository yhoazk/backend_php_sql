<?php
require 'KartingDB.php';

class Driver {
  function __construct(){}

  public static function getAll(){
    $query = "SELECT * FROM driver";

    try {
      $qcmd = KartingDB::getInstance()->getDb()->prepare($query);
      $qcmd->execute();
      return $qcmd->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      return false;
    }

  }
}
?>
