<?php

namespace App;

use App\Route\IndexRoute;
use Kod\BootstrapSlim\Bootstrap as BootstrapSlim;

/**
 * Bootstrap
 */
class Bootstrap extends BootstrapSlim
{

    public function addAppMiddleware()
    {
        return parent::addAppMiddleware();
    }

    public function addAppRoutes()
    {
        return $this->addRouteDefinitions(
            IndexRoute::class
        );
    }
}
