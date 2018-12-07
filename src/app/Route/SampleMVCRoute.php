<?php
/**
 * Copyright (c) 2018 Konstantin Deryabin <kderyabin@orange.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Route;

use App\MVC\Controller\SampleController;
use Kod\BootstrapSlim\RouteDefinitions;
use Slim\App;

/**
 * SampleRoute
 */
class SampleMVCRoute extends RouteDefinitions
{

    /**
     * @param App $app
     */
    public function __invoke($app): void
    {
        $app->get('/mvc', SampleController::class . ':main');
    }
}
