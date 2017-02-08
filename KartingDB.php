<?php
/**
* Filename: KartingDB.php
*/

require_once  'db_login.php';

class KartingDB {
  private static $db = null;
  private static $pdo;

  /* Initalize the class */
  //public static function __construct(){
  final private function __construct(){
    try {
        self::getDb();
    } catch ( PDOExeption $e) {

    }

  }

  public static function getInstance(){
    if(self::$db == null){
      self::$db  = new self();
    }
    return self::$db;
  }

  public function getDb(){
    if(self::$pdo == null){
      self::$pdo = new PDO(
            'mysql:dbname='.DATABASE.
            ';host='.HOSTNAME.
            ';port:3306',
            USERNAME,
            PASSWORD,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
          );
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return self::$pdo;
  }

  final protected function __clone(){}
  function __destructor(){
    self::$pdo = null;
  }
}

?>
