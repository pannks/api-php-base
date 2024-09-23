<?php

namespace App\Routes;

use App\Utils\Response;

class RouteV2 extends BaseRoute
{
  protected function registerServices() {}

  protected function registerControllers() {}

  protected function defineRoutes()
  {

    $this->route('test')
      ->add('GET', '', fn() => Response::json('Hello, World!'));
  }
}
