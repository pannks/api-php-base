<?php

namespace App\Interfaces;

interface UserServiceInterface
{
  public function findAll(): array;
  public function findOne(int $id): ?array;
  public function create(array $data): int;
  public function update(int $id, array $data): bool;
  public function delete(int $id): bool;
}
