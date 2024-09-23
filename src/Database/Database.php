<?php

namespace App\Database;

use PDO;
use PDOException;
use Exception;

class Database
{
  private static $instance = null; // Store the single instance
  private $connection; // Store the PDO connection
  private $host;
  private $dbname;
  private $user;
  private $pass;
  private $port = 3306;

  // Make the constructor private to prevent direct object creation
  private function __construct($host, $dbname, $user, $pass, $port = 3306)
  {
    $this->host = $host;
    $this->dbname = $dbname;
    $this->user = $user;
    $this->pass = $pass;
    $this->port = $port;

    // Create the database connection
    try {
      $this->connection = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->dbname}", $this->user, $this->pass);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      throw new Exception('Connection Error: ' . $e->getMessage());
    }
  }

  /**
   * Get the single instance of the Database class
   *
   * @param string $host
   * @param string $dbname
   * @param string $user
   * @param string $pass
   * @param int $port
   * @return Database
   */
  public static function getInstance(string $host, string $dbname, string $user, string $pass, int $port = 3306): Database
  {
    if (self::$instance === null) {
      self::$instance = new self($host, $dbname, $user, $pass, $port);  // Using positional arguments here
    }

    return self::$instance;
  }

  /**
   * Get the PDO connection
   *
   * @return PDO
   */
  public function getConnection(): PDO
  {
    return $this->connection;
  }

  // Prevent cloning of the object
  private function __clone() {}

  // Prevent unserializing of the object
  public function __wakeup() {}
}
