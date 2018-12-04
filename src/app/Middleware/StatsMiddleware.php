<?php

namespace App\Middleware;

use Kod\BootstrapSlim\Middleware;
use Kod\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * StatsMiddleware
 */
class StatsMiddleware extends Middleware
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
        $start = microtime(true);
        /**
         * @var ResponseInterface $response
         */
        $response = $next($request, $response);

        $data = [
            'response_size' => $response->getBody()->getSize(),
            'response_time' => microtime(true) - $start,
            'status' => $response->getStatusCode()
        ];
        /**
         * @var Logger $logger
         */
        $logger = $this->ci->get('logger');
        $logger->info('Execution time', $data);

        return $response;
    }
}
