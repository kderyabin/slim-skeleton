<?php
namespace App\Route;

use Kod\BootstrapSlim\RouteDefinitions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Views\PhpRenderer;

/**
 * SampleRoute
 */
class SampleRoute extends RouteDefinitions
{

    /**
     * @param App $app
     */
    public function __invoke($app)
    {
        $app->get('/', function (ServerRequestInterface $request, ResponseInterface $response, $next) {
            /**
             * @var PhpRenderer $renderer
             */
            $renderer = $this->get('renderer');
            $content = [
                'data' => $_SERVER,
            ];

            return $renderer->render($response, 'sample.phtml', $content);
        });
    }
}
