<?php

  class Database{

    protected $connection = false;
    private $statement;

    public function __construct(){
      // Constructor is called when the database class is initialised
      // Establishes the connection to the database

      // Database connection details
      $config = array(
        "database" => array(
          "host"=> 'localhost',
          "database" => 'library',
          "username" => 'root',
          "password" => 'root'
        )
      );

      // Set PDO instantiation options
      $options = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      );

      // Create a new PDO instance with connection details and options
      try {
        $this->connection = new PDO("mysql:host=".$config["database"]["host"].";dbname=".$config["database"]["database"], $config["database"]["username"], $config["database"]["password"], $options);
      }
      catch (PDOException $e) {
        $this->error = $e->getMessage();
      }
    }

    public function __destruct(){
      // Destructor is called when there are no further references to the database class
      // Closes the connection to the database
      if($this->connection != false) {
          $this->connection=null;
      }
    }

    public function prepare($query){
      // PDO prepare allows for binding of values, removes threat of SQL injection and improves query performance
      $this->statement = $this->connection->prepare($query);
    }

    public function bind($parameter, $value, $type = null){
      // PDO bindValue binds inputs to placeholders
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

    public function execute($success = "Success",$print = false){
      // Executes the prepared statement
      try {
        $this->statement->execute();
        if ($print) {
          echo "<div class=\"alert alert-success\" role=\"alert\">$success";
          echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span>
          </button></div>";
        }
      }
      catch (PDOException $error) {
        echo "<div class=\"alert alert-danger\" role=\"alert\">Connection failed - " .  $error->getMessage();
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button></div>";
      }
    }

    public function allresults(){
      // Returns all results
      $this->execute("",false);
      return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function singleresult(){
      // Returns a single result
      $this->execute("",false);
      return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount(){
      // Returns the number of rows
      return $this->statement->rowCount();
    }

    public function lastInsertId(){
      // Returns the ID of the last inserted record
      return $this->connection->lastInsertId();
    }

    public function beginTransaction(){
      // Transactions allow batch changes of queries that are dependent on one another
      // If an exception is thrown due to a failed query, we can undo changes by returning to the beginning of the transaction
      return $this->connection->beginTransaction();
    }

    public function endTransaction(){
      // Ends the transaction, and commits all changes
      return $this->connection->commit();
    }

    public function cancelTransaction(){
      // Cancels the transaction
      return $this->connection->rollBack();
    }

    public function debugDumpParams(){
      // Dumps the data in the prepared statement
      return $this->statement->debugDumpParams();
    }

    public function success_alert($message) {
      echo "<div class=\"alert alert-success\" role=\"alert\">$message";
    }

    public function danger_alert($message) {
      echo "<div class=\"alert alert-danger\" role=\"alert\">Connection failed - " .  $message;
    }

    public function close_alert() {
      echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
      </button></div>";
    }
  }

    ?>
