<?php

namespace App\Models;

use PDO;

abstract class BaseModel
{

  protected $pdo;
  protected $table;
  protected $primaryKey = 'id'; // Default primary key
  protected $fillable = [];
  protected $columns = [];

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  /**
   * Filter data according to fillable fields.
   * 
   * @param array $data
   * @return array
   */
  protected function filterFillable(array $data): array
  {
    return array_filter(
      $data,
      fn($key) => in_array($key, $this->fillable),
      ARRAY_FILTER_USE_KEY
    );
  }

  /**
   * Get all records from the table.
   * 
   * @return array
   */
  public function findAll(): array
  {
    $sql = "SELECT * FROM {$this->table}";
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Create a new record.
   * 
   * @param array $data
   * @return int The last inserted ID
   */
  public function create(array $data): int
  {
    $data = $this->filterFillable($data); // Only allow fillable fields

    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_map(fn($key) => ":$key", array_keys($data)));

    $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($data);

    return $this->pdo->lastInsertId();
  }

  /**
   * Update an existing record by ID.
   * 
   * @param int $id
   * @param array $data
   * @return bool True on success, false on failure
   */
  public function find(int $id): ?array
  {
    $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result === false) {
      return null;
    }

    return $result;
  }

  public function update(int $id, array $data): bool
  {
    $data = $this->filterFillable($data);
    $columns = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
    $sql = "UPDATE {$this->table} SET $columns WHERE {$this->primaryKey} = :id";

    $stmt = $this->pdo->prepare($sql);
    $data['id'] = $id;
    return $stmt->execute($data);
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
  }
}
