<?php

namespace App;

use App\Middleware\SampleMiddleware;
use App\Route\SampleMVCRoute;
use App\Route\SampleRoute;
use Kod\BootstrapSlim\Bootstrap as BootstrapSlim;

/**
 * Bootstrap
 */
class Bootstrap extends BootstrapSlim
{

    public function addAppMiddleware()
    {
        return $this->addMiddleware(
            SampleMiddleware::class
        );
    }

    public function addAppRoutes()
    {
        return $this->addRouteDefinitions(
            SampleRoute::class,
            SampleMVCRoute::class
        );
    }
}
