<?php

namespace App\Models;

use PDO;

class User extends BaseModel
{
  protected $table = 'users';
  protected $primaryKey = 'id';
  protected $fillable = [
    'email',
    'firstname',
    'lastname',
    'password_hash'
  ];
  protected $columns = [
    'user_id' => 'int',
    'email' => 'string',
    'firstname' => 'string',
    'lastname' => 'string',
    'password_hash' => 'string',
    'created_at' => 'datetime',
    'updated_at' => 'datetime'
  ];

  /**
   * Find a user by email.
   *
   * @param string $email
   * @return array|null
   */
  public function findByEmail(string $email): ?array
  {
    $sql = "SELECT * FROM {$this->table} WHERE email = :email";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
  }
}
