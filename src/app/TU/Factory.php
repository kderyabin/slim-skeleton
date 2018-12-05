<?php

namespace App\TU;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;

/**
 * SlimRequest
 */
class Factory
{

    public static function prepareEnv(array $data = []): Environment
    {
        return Environment::mock($data);
    }

    /**
     * Get environment corresponding to the request
     *
     * @param ServerRequestInterface $request
     * @return Environment
     */
    public static function getEnvFromRequest(ServerRequestInterface $request)
    {
        $server = $request->getServerParams();
        return Environment::mock($server);
    }

    /**
     * @param array $data
     * @return Environment
     */
    protected static function getEnv(array $data): Environment
    {
        return Environment::mock($data);
    }
    /**
     *
     * @param string $method GET, POST, PUT, PATCH, DELETE
     * @param string $path
     * @param array $env    raw http headers and other and other env vars
     * @param string|array $body  body content
     * @return Request
     */
    public static function getRequest(string $method, string $path, array $env = [], $body = '')
    {
        $requestBody = null;
        $method = strtoupper($method);
        $base = array(
            'REQUEST_METHOD' => $method,
            'REQUEST_URI' => $path,
        );
        if ($method !== 'GET') {
            $base['CONTENT_LENGTH'] = strlen($body);
        }

        $env = array_merge($base, $env);
        $request = Request::createFromEnvironment(
            Environment::mock(array_merge($base, $env))
        );

        if ($method !== 'GET') {
            $requestBody = new RequestBody();
            $requestBody->write($body);
            return $request->withBody($requestBody);
        } else {
            return $request;
        }
    }

    /**
     * @param array $headers
     * @param string $body
     * @param int $httpCode
     * @return Response
     */
    public static function getResponse($headers = [], $body = '', $httpCode = 200)
    {
        //build response

        $head = new Headers();
        $head->add('Content-Type', 'application/json; charset=UTF-8');
        if (count($headers) > 0) {
            foreach ($headers as $key => $val) {
                $head->add($key, $val);
            }
        }

        $response = new Response($httpCode, $head);
        //add body
        $response->write($body);

        return $response;
    }
}
