<?php

class Person
{
  private string $hostName;
  private string $userName;
  private string $password;
  private string $dbName;

  private $connection;
  private $statement;

  public function __construct()
  {
      $this->hostName = 'localhost';
      $this->userName = 'root';
      $this->password = '';
      $this->dbName = 'internClass';
  }

  public function getConnection()
  {
      $this->connection = new mysqli($this->hostName, $this->userName, $this->password, $this->dbName);

      if ($this->connection->connect_error) {
          die("Connection failed: " . $this->connection->connect_error);
      }
  }

  public function createStatement($query)
  {
    $this->getConnection();
    $this->statement = $this->connection->prepare($query);
  }

  public function bindValues(string $types, array $valueArr)
    {
        $this->statement->bind_param($types, ...$valueArr);
    }

  public function execute()
  {
    return $this->statement->execute();
  }

  public function getResult()
  {
    return $this->statement->get_result()->fetch_all(MYSQLI_ASSOC);
  }
} 