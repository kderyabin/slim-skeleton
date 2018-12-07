<?php
/**
 * Copyright (c) 2018 Konstantin Deryabin <kderyabin@orange.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Middleware;

use Kod\BootstrapSlim\Middleware;
use Kod\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * SampleMiddleware
 */
class SampleMiddleware extends Middleware
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        $start = round(microtime(true) * 1000);
        /**
         * @var Logger $logger
         */
        $logger = $this->ci->get('logger');
        /**
         * @var ResponseInterface $response
         */
        $request = $request->withAttribute('title', 'Sample');
        $response = $next($request, $response);
        $data = [
            'response_size' => $response->getBody()->getSize(),
            'response_time' => round(microtime(true) * 1000) - $start,
            'status' => $response->getStatusCode(),
        ];

        $logger->info('Middleware stack traversal time', $data);
        return $response;
    }
}
