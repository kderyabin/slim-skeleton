<?php
/**
 * Copyright (c) 2018 Konstantin Deryabin <kderyabin@orange.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     * Inside group closure, $this is bound to the instance of Slim\App
     * Inside route closure, $this is bound to the instance of Slim\Container
     * @see https://www.slimframework.com/docs/v3/objects/router.html#how-to-create-routes
     * @param App $app
     */
    public function __invoke($app): void
    {
        $app->get('/', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
            /**
             * @var PhpRenderer $renderer
             */
            $renderer = $this->get('renderer');
            $content = [
                'title' => $request->getAttribute('title'),
                'data' => $this->get('environment')->all(),
            ];

            return $renderer->render($response, 'sample.phtml', $content);
        })->setName('main');
    }
}
