<?php

class LocalDB {
  private $tableName;
  private $pdo;
  private $statement;

  public function __construct($dbName, $tableName) {
    $this->tableName = $tableName;
    try {
      $this->pdo = new PDO("sqlite:{$dbName}");
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
  }

  public function getArray($rowName) {
    try {
      $this->statement = $this->pdo->query("SELECT {$rowName} FROM {$this->tableName}");
      $result = $this->statement->fetchAll();
      return array_column($result, $rowName);
    } catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
  }
}
