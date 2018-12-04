<?php

namespace App\Middleware;

use Kod\BootstrapSlim\Middleware;
use Kod\Logger;
use Kod\Utils\Date;
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
        $response = $next($request, $response);
        $data = [
            'response_size' => $response->getBody()->getSize(),
            'response_time' => round(microtime(true) * 1000) - $start,
            'status' => $response->getStatusCode(),
        ];

        $logger->info('Execution time', $data);

        return $response;
    }
}
