<?php

class LocalDB {
  protected $connection = false;
  private $statement;

  public function __construct() {
    $config = array (
      "DB_HOST" => $_ENV['DB_HOST'],
      "DB_DATABASE" => $_ENV['DB_DATABASE'],
      "DB_USERNAME" => $_ENV['DB_USERNAME'],
      "DB_PASSWORD" => $_ENV['DB_PASSWORD']
    );
    $options = array(
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    try {
      $this->connection = new PDO("mysql:host=".$config["DB_HOST"].";dbname=".$config["DB_DATABASE"], $config["DB_USERNAME"], $config["DB_PASSWORD"], $options);
    }
    catch (PDOException $e) {
      $this->error = $e->getMessage();
    }
  }

  public function __destruct() {
    if($this->connection != false) {
        $this->connection = null;
    }
  }

  public function prepare($query) {
    $this->statement = $this->connection->prepare($query);
  }

  public function bind($parameter, $value, $type = null) {
    if(is_null($type)){
      switch(true){
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }
    $this->statement->bindValue($parameter, $value, $type);
  }

  public function execute() {
    try {
      $this->statement->execute();
    }
    catch (PDOException $e) {
      $this->error = $e->getMessage();
    }
  }

  public function allresults() {
    return $this->statement->fetchAll(PDO::FETCH_ASSOC);
  }

  public function singleresult() {
    return $this->statement->fetch(PDO::FETCH_ASSOC);
  }

  public function rowCount() {
    return $this->statement->rowCount();
  }

  public function lastInsertId() {
    return $this->connection->lastInsertId();
  }

  public function beginTransaction() {
    return $this->connection->beginTransaction();
  }

  public function endTransaction() {
    return $this->connection->commit();
  }

  public function cancelTransaction() {
    return $this->connection->rollBack();
  }

  public function debugDumpParams() {
    return $this->statement->debugDumpParams();
  }
}

?>
