<?php

namespace App\Tests\Helper;

use App\Helper\SlimHttpFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\UploadedFile;

class SlimHttpFactoryTest extends TestCase
{
    protected static $config = [];

    public static function setUpBeforeClass()
    {
        static::$config = require TEST_CONF_DIR . '/config.php';
    }

    /**
     * @testdox Should mock a POST request with the form data passed as an array
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
        $env = SlimHttpFactory::mockRequest('POST', '/', $headers, $body);
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
     * @testdox Should mock a POST request with the form data passed as a string
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
        $env = SlimHttpFactory::mockRequest('POST', '/', $headers, $body);
        $config = array_merge(static::$config, $env);
        /**
         * @var Request $request
         */
        $request = $config['request'];

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals($body, (string)$request->getBody());
    }

    /**
     * @testdox Should mock a PUT request with some json data
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
        $env = SlimHttpFactory::mockRequest('PUT', '/', $headers, json_encode($body));
        $config = array_merge(static::$config, $env);
        /**
         * @var Request $request
         */
        $request = $config['request'];

        $this->assertEquals('PUT', $request->getMethod());
        $this->assertEquals('application/json', $request->getHeaderLine('content-type'));
        $this->assertEquals(json_encode($body), (string)$request->getBody());
    }

    /**
     * @testdox Should mock response
     */
    public function testResponseGeneration()
    {
        $requestId = 123456789;
        $headers = ['HTTP_X_REQUEST_ID' => $requestId];
        $response = SlimHttpFactory::mockResponse(500, $headers, 'Server is down');

        $this->assertEquals($requestId, $response->getHeaderLine('x-request-id'));
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Server is down', (string)$response->getBody());
    }

    /**
     * @testdox Should mock files uploading and move them  without the error
     */
    public function testUploadedFiles()
    {
        $testImg = TEST_TMP_DIR . '/img.jpg';
        $moveTo = TEST_TMP_DIR . '/test.jpg';
        $files = [
            'test' => [
                'name' => 'img.jpg',
                'type' => 'image/jpeg',
                'size' => filesize($testImg),
                'tmp_name' => $testImg,
                'error' => 0
            ]
        ];

        $headers = [
            'CONTENT_TYPE' => 'multipart/form-data'
        ];
        $body = '';
        $config = SlimHttpFactory::mockRequest('POST', '/', $headers, $body, $files);
        /**
         * @var Request $request
         */
        $request = $config['request'];
        $uploaded = $request->getUploadedFiles();

        $this->assertArrayHasKey('test', $uploaded);
        /**
         * @var UploadedFile $file
         */
        $file = $uploaded['test'];
        $this->assertEquals($files['test']['name'], $file->getClientFilename());

        $file->moveTo($moveTo);
        $this->assertFileExists($moveTo);
        rename($moveTo, $testImg);
    }
}
