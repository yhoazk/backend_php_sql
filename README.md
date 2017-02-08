# backend_php_sql

# Notes
This is a tutorial from:
[http://www.hermosaprogramacion.com/2015/05/crear-un-webservice-para-android-con-mysql-php-y-json/](http://www.hermosaprogramacion.com/2015/05/crear-un-webservice-para-android-con-mysql-php-y-json/)


## DB para pruebas

| Driver    |
| :------   |
| id        |
| name      |
| nickName      |
| lastLogin |


Crear base de datos
```sql
CREATE  DATABASE Karting;
```
Crear Tabla

```sql
CREATE TABLE IF NOT EXISTS driver(
    id int(6) PRIMARY KEY AUTO_INCREMENT,
  name varchar(32) NOT NULL,
  nickName varchar(128) NOT NULL,
  prioridad enum('Alta','Media','Baja','') NULL DEFAULT 'Alta',
  fechaLim date NOT NULL,
  categoria enum('Salud','Finanzas','Espiritual','Profesional','Material') NOT NULL DEFAULT 'Finanzas'
)
```

Anadiendo registros de prueba:

```sql
INSERT INTO `Karting`.`driver` (`id`, `name`, `nickName`, `prioridad`, `fechalim`, `categoria`)
VALUES (NULL,
'Josefa',
'JoFa',
'Media',
'2015-11-20',
'Material'),
(NULL,
'Martin',
'Mat',
'Alta',
'2016-06-17',
'Profesional'),
(NULL,
'Natasha',
'Nat',
'Alta',
'2015-05-25',
'Espiritual'),
(NULL,
'Taco',
'Taco',
'Baja',
'2016-05-13',
'Salud'),
(NULL,
'Ramon',
'Ramion',
'Media',
'2015-10-13',
'Finanzas');

```


## Conexion PHP

### Crear conexion singleton con DB


```php
<? php
/**
* Filename: KartingDB.php
*/

require_once  'db_login.php';

class KartingDB {
  private static $db = null;
  private static $pdo;

  /* Initalize the class */
  public static function __construct(){
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
      self:$pdo = new PDO(
            'mysql:dbname='.DATABASE.
            ';host='.HOSTNAME.
            ';port:63343',
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
    self:$pdo = null
  }
}

?>
```

Por seguridad los datos de la DB se alamcenan en `db_login.php`

```php
<?php
  define("HOSTNAME","localhost");
  define("DATABASE","Karting");
  define("USERNAME","root");
  define("PASSWORD",""); // no passwd for test
 ?>
```
Ahora una abstracion para cada tabla y las correspondientes funciones para
insertar, actualizar y leer.

```php
/* Filename: Driver.php */
<?php
require 'KartingDB.php'

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
```


Ahora el script que llama a los demas

```php
<? php
require 'driver.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $drv = Driver::getAll();

  if($drv){
    $resp['response'] = 1;
    $resp['drivers'] = $drv;
    print json_encode($resp);
  }
  else {
    print json_encode(array("estado" = 2, "error" = "Error drv"));
  }
}
?>

```


- - -
# SQL commands
```sql
FROM myDB SELECT places WHERE id >4;
```

# MySQL

RDMBS: Relational database Management system.
Is a database Management system that is based on the relational model


### Relational model:
Is an approach to managing data using a structure and language consistent
with `first order predicate logic`.

In the relational model of database, all data is represented in terms of
tuples, grouped into relations. A database organized in terms of the
relational model is a relational database.

Today the RDMBS is used to stora and manage huge volime of data, This is
called relational database because all the data is stored into different
tables and relations are established using primary keys or other keys
known as foreing keys.

A RDMBS is a SW that enables:
  - Implement database with tables, columns and indexes.
  - Guarantees the referential integrity between rown of various tables.
  - Updates the indexes automatically
  - Interprets an SQL query and combines information from various tables.

### RDMBS terminology

- Primary keys
  A Primary key is unique. A key value cannot occur twice in one table.
  With a key, you can find at most one row
- Foreing key
  A foreing key is the linking pin between two tables.
- Compound key
  Is a key that consists of multiple columns, because one column is not
  sufficiently unique.
- Referential integrity
  Referential integrity makes sure that a foreing key value always points
  to an existing row.

When installing all the MySQL related binaries are installed in `/usr/bin`
and `/usr/sbin`. All the tables and databases will be createds in
`/var/lib/mysql` dir.

### Post-installation steps:
MySQL ships with a blank password for the root MySQL user.
As soon as you have successfully installed the database and client



#### Testing installation
```
$ mysqladmin --version
```

### Execute simple commands with MySQL client
```

```
#### Check if MySQL is up and running
```
[porko@A mysql] $ ps -ef | grep mysqld
porko     5380  5351  0 16:05 pts/5    00:00:00 grep --color=auto mysqld  
```
