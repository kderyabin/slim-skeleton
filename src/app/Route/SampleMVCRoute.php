<?php
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
