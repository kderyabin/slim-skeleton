<?php
namespace App\Route;

use Kod\BootstrapSlim\RouteDefinitions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;


/**
 * IndexRoute
 */
class IndexRoute extends RouteDefinitions
{

    /**
     * @param App $app
     */
    public function __invoke($app)
    {
        $app->get('/', function(ServerRequestInterface $request, ResponseInterface $response, $next){
            $response->getBody()->write('Hello!');
            return $response;
        });
    }
}
