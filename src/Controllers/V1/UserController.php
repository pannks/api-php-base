<?php

namespace App\Controllers\V1;

use App\Utils\Request;
use App\Utils\Response;
use App\Services\V1\UserService;
use App\Utils\Validators\CreateUserValidator;
use App\Utils\Validators\UpdateUserValidator;

class UserController
{
  private $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function getAll(Request $request): void
  {
    $users = $this->userService->findAll();

    if (!empty($request->queryParams)) {
      // Use the unified request object to access queryParams and headers dynamically
      echo Response::json([
        'message' => 'Users with filters',
        'users' => $users,
        'filters' => $request->queryParams,
        'headers' => $request->headers,
      ]);
    } else {
      echo Response::json(['users' => $users]);
    }
  }

  public function getById(Request $request): void
  {
    $user = $this->userService->findOne($request->params['id']);

    if ($user) {
      echo Response::json([
        'user' => $user,
        'id' => $request->params['id'],
        'filters' => $request->queryParams,
        'headers' => $request->headers
      ]);
    } else {
      echo Response::json(['message' => 'User not found', 'id' => $request->params['id']], 404);
    }
  }

  public function create(Request $request): void
  {

    $validationErrors = CreateUserValidator::validate($request->body);

    if (!empty($validationErrors)) {
      // Respond with validation errors
      echo Response::json(['errors' => $validationErrors], 400);
      return;
    }

    $userId = $this->userService->create($request->body);
    echo Response::json(['message' => 'User created', 'user_id' => $userId, 'data' => $request->body]);
  }

  public function update(Request $request): void
  {

    $validationErrors = UpdateUserValidator::validate($request->body);

    if (!empty($validationErrors)) {
      echo Response::json(['errors' => $validationErrors], 400);
      return;
    }

    $this->userService->update($request->params['id'], $request->body);
    echo Response::json(['message' => 'User updated', 'id' => $request->params['id'], 'data' => $request->body]);
  }

  public function delete(Request $request): void
  {
    $this->userService->delete($request->params['id']);
    echo Response::json(['message' => 'User deleted', 'id' => $request->params['id']]);
  }
}
