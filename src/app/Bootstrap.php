<?php
/**
 * Copyright (c) 2018 Konstantin Deryabin <kderyabin@orange.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
