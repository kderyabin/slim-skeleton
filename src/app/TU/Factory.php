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

    public static function prepareEnv(string $method, string $path, array $env = [], $body = null): Environment
    {
        $method = strtoupper($method);
        $base = array(
            'REQUEST_METHOD' => $method,
            'REQUEST_URI' => $path,
        );
        if ($method !== 'GET') {
            if ($method === 'POST' && in_array($env['CONTENT_TYPE'],  ['application/x-www-form-urlencoded', 'multipart/form-data'])) {
                if (is_string($body)) {
                    parse_str($body, $_POST);
                } else {
                    $_POST = $body;
                }
            }
        }

        $env = array_merge($base, $env);

        if ($method === 'POST' && in_array($env['CONTENT_TYPE'],  ['application/x-www-form-urlencoded', 'multipart/form-data'])) {
            if (is_string($body)) {
                parse_str($body, $_POST);
            } else {
                $_POST = $body;
            }
        }
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
     * @param string $method
     * @param string $path
     * @param string $body
     * @param array $env
     * @return RequestInterface
     */
    public static function getRequest(string $method, string $path,  $body = '', array $env = []): RequestInterface
    {
        $requestBody = null;
        $method = strtoupper($method);
        $base = array(
            'REQUEST_METHOD' => $method,
            'REQUEST_URI' => $path,
        );
        if ($method !== 'GET') {
            if ($method === 'POST' && in_array($env['CONTENT_TYPE'],  ['application/x-www-form-urlencoded', 'multipart/form-data'])) {
                if (is_string($body)) {
                    parse_str($body, $_POST);
                    $base['CONTENT_LENGTH'] = strlen($body);
                } else {
                    $_POST = $body;
                    $base['CONTENT_LENGTH'] = strlen(http_build_query($body));
                }
            } else {
                $base['CONTENT_LENGTH'] = strlen($body);
            }
        }

        $request = Request::createFromEnvironment(
            Environment::mock(array_merge($env, $base))
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
