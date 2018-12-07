<?php
/**
 * Copyright (c) 2018 Konstantin Deryabin <kderyabin@orange.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Helper;

use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;

/**
 * Class SlimHttpFactory
 * @package App\Helper
 */
class SlimHttpFactory
{
    /**
     * @param string $method
     * @param string $path
     * @param array $serverParams
     * @param string|array $body    String but can be an array for POST method
     * @param array $uploadedFiles
     * @return array
     */
    public static function mockRequest(
        string $method,
        string $path,
        array $serverParams = [],
        $body = '',
        array $uploadedFiles = []
    ) {
        $requestBody = null;
        $method = strtoupper($method);
        $base = array(
            'REQUEST_METHOD' => $method,
            'REQUEST_URI' => $path,
        );
        if ($method !== 'GET') {
            if ($method === 'POST' && isset($serverParams['CONTENT_TYPE']) && in_array(
                $serverParams['CONTENT_TYPE'],
                ['application/x-www-form-urlencoded', 'multipart/form-data']
            )) {
                if (is_string($body)) {
                    //parse_str($body, $_POST);
                    $base['CONTENT_LENGTH'] = strlen($body);
                } else {
                    //$_POST = $body;
                    $body = http_build_query($body);
                    $base['CONTENT_LENGTH'] = strlen($body);
                }

                if ($uploadedFiles && $serverParams['CONTENT_TYPE'] === 'multipart/form-data') {
                    $base['slim.files'] = CliUploadedFile::parseUploadedFiles($uploadedFiles);
                }
            } else {
                $base['CONTENT_LENGTH'] = strlen($body);
            }
        }
        $environment = Environment::mock(
            array_merge($serverParams, $base)
        );
        $request = Request::createFromEnvironment($environment);
        if ($method !== 'GET') {
            $requestBody = new RequestBody();
            $requestBody->write($body);
            $request = $request->withBody($requestBody);
        }

        return [
            'environment' => $environment,
            'request' => $request
        ];
    }
    /**
     * @param array $headers
     * @param string $body
     * @param int $httpCode
     * @return Response
     */
    public static function mockResponse($httpCode = 200, $headers = [], $body = '')
    {
        $head = new Headers();
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
