<?php
// src/Interfaces/MiddlewareInterface.php
namespace App\Interfaces;

use App\Utils\Request;

interface MiddlewareInterface
{
  public function handle(Request $request, callable $next);
}
