<?php

namespace App\Services\V1;

use PDO;
use App\Models\User;
use App\Interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{
  private User $userModel;

  public function __construct(PDO $pdo)
  {
    $this->userModel = new User($pdo);
  }

  /**
   * Retrieve all users.
   *
   * @return array
   */
  public function findAll(): array
  {
    return $this->userModel->findAll();
  }

  /**
   * Find a user by ID.
   *
   * @param int $id
   * @return array|null
   */
  public function findOne(int $id): ?array
  {
    return $this->userModel->find($id) ?? null;
  }

  /**
   * Create a new user.
   *
   * @param array $data
   * @return int The ID of the newly created user.
   */
  public function create(array $data): int
  {
    $this->validateUserData($data);

    // Hash the password before saving
    if (isset($data['password'])) {
      $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
      unset($data['password']); // Remove plain password
    }

    return $this->userModel->create($data);
  }

  /**
   * Update an existing user.
   *
   * @param int $id
   * @param array $data
   * @return bool
   */
  public function update(int $id, array $data): bool
  {
    $this->validateUserData($data, $id);

    // Hash the password if it's being updated
    if (isset($data['password'])) {
      $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
      unset($data['password']); // Remove plain password
    }

    return $this->userModel->update($id, $data);
  }

  /**
   * Delete a user by ID.
   *
   * @param int $id
   * @return bool
   */
  public function delete(int $id): bool
  {
    return $this->userModel->delete($id);
  }

  /**
   * Validate user data before creating or updating.
   *
   * @param array $data
   * @param int|null $id The ID of the user (for updates).
   * @throws \InvalidArgumentException
   */
  private function validateUserData(array $data, int $id = null): void
  {
    // Validate email
    if (isset($data['email'])) {
      if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        throw new \InvalidArgumentException('Invalid email format.');
      }

      // Check for unique email
      if ($this->isEmailTaken($data['email'], $id)) {
        throw new \InvalidArgumentException('Email is already in use.');
      }
    } elseif ($id === null) {
      throw new \InvalidArgumentException('Email is required.');
    }

    // Validate firstname
    if (isset($data['firstname']) && empty(trim($data['firstname']))) {
      throw new \InvalidArgumentException('First name cannot be empty.');
    }

    // Validate lastname
    if (isset($data['lastname']) && empty(trim($data['lastname']))) {
      throw new \InvalidArgumentException('Last name cannot be empty.');
    }

    // Validate password (only on create or if password is being updated)
    if (($id === null || isset($data['password'])) && empty($data['password'])) {
      throw new \InvalidArgumentException('Password cannot be empty.');
    }
  }

  /**
   * Check if an email is already taken by another user.
   *
   * @param string $email
   * @param int|null $id The ID of the current user (to exclude from check).
   * @return bool
   */
  private function isEmailTaken(string $email, int $id = null): bool
  {
    $existingUser = $this->userModel->findByEmail($email);

    if ($existingUser) {
      if ($id !== null && $existingUser['user_id'] == $id) {
        return false; // Email belongs to the same user
      }
      return true; // Email is taken
    }

    return false;
  }
}
