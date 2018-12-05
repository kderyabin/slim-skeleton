<?php
namespace App\Route;

use App\MVC\Controller\SampleController;
use Kod\BootstrapSlim\RouteDefinitions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Views\PhpRenderer;

/**
 * SampleRoute
 */
class SampleMVCRoute extends RouteDefinitions
{

    /**
     * @param App $app
     */
    public function __invoke($app)
    {
        $app->get('/mvc', SampleController::class . ':main');
    }
}
