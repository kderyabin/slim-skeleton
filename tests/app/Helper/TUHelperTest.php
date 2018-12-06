<?php

namespace App\Tests\Helper;

use App\Bootstrap;
use App\Helper\TUHelper;
use App\Route\SampleRoute;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

class TUHelperTest extends TestCase
{
    protected static $config = [];

    public static function setUpBeforeClass()
    {
        static::$config = require TEST_CONF_DIR . '/config.php';
    }

    /**
     * @testdox
     */
    public function testRequestPostArray()
    {
        $requestId = 123456789;
        $headers = [
            'HTTP_X_REQUEST_ID' => $requestId,
            'CONTENT_TYPE' => 'application/x-www-form-urlencoded'
        ];
        $body =  [
            'fname' => 'John',
            'lname' => 'Doe'
        ];
        $env = TUHelper::prepareRequest('POST', '/', $headers, $body);
        $config = array_merge(static::$config, $env);
        /**
         * @var Request $request
         */
        $request = $config['request'];
        $expected = http_build_query($body);

        $this->assertInstanceOf(Environment::class, $config['environment']);
        $this->assertInstanceOf(RequestInterface::class, $config['request']);
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals($expected, (string)$request->getBody());
        $this->assertEquals(strlen($expected), (int)$request->getHeaderLine('content-length'));
        $this->assertEquals('application/x-www-form-urlencoded', $request->getHeaderLine('content-type'));
        $this->assertEquals($requestId, $request->getHeaderLine('x-request-id'));
    }

    /**
     * @testdox
     */
    public function testRequestPostString()
    {
        $headers = [
            'CONTENT_TYPE' => 'application/x-www-form-urlencoded'
        ];
        $body =  http_build_query([
            'fname' => 'John',
            'lname' => 'Doe'
        ]);
        $env = TUHelper::prepareRequest('POST', '/', $headers, $body);
        $config = array_merge(static::$config, $env);
        /**
         * @var Request $request
         */
        $request = $config['request'];

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals($body, (string)$request->getBody());
    }

    /**
     * @testdox
     */
    public function testRequestPutJson()
    {
        $headers = [
            'CONTENT_TYPE' => 'application/json'
        ];
        $body =  [
            'fname' => 'John',
            'lname' => 'Doe'
        ];
        $env = TUHelper::prepareRequest('PUT', '/', $headers, json_encode($body));
        $config = array_merge(static::$config, $env);
        /**
         * @var Request $request
         */
        $request = $config['request'];

        $this->assertEquals('PUT', $request->getMethod());
        $this->assertEquals('application/json', $request->getHeaderLine('content-type'));
        $this->assertEquals(json_encode($body), (string)$request->getBody());
    }

    public function testResponseGeneration()
    {
        $requestId = 123456789;
        $headers = ['HTTP_X_REQUEST_ID' => $requestId];
        $response = TUHelper::getResponse(500, $headers, 'Server is down');

        $this->assertEquals($requestId, $response->getHeaderLine('x-request-id'));
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Server is down', (string)$response->getBody());
    }
}
