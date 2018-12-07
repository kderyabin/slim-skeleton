<?php

namespace App\Tests\app\Route;

use App\Bootstrap;
use App\Helper\SlimHttpFactory;
use App\Route\SampleRoute;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Http\Response;

class SampleRouteTest extends TestCase
{
    protected static $config = [];

    public static function setUpBeforeClass()
    {
        static::$config = require TEST_CONF_DIR . '/config.php';
    }

    /**
     * @testdox Test the SampleRoute output
     */
    public function testSampleRoute()
    {
        $config = array_merge(
            static::$config,
            SlimHttpFactory::mockRequest('GET', '/')
        );
        /**
         * @var Response $response
         */
        $response = (new Bootstrap(App::class, $config))
            ->addRouteDefinitions(SampleRoute::class)
            ->run(true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('html', $response->getHeaderLine('content-type'));
        $content = (string)$response->getBody();
        // without the middleware the title is empty
        $this->assertContains('<title></title>', $content);
        $this->assertContains('[REQUEST_TIME_FLOAT]', $content);
    }

    /**
     * @testdox Test the SampleRoute output in application workflow
     */
    public function testSampleRouteWithMiddleware()
    {
        $config = array_merge(
            static::$config,
            SlimHttpFactory::mockRequest('GET', '/')
        );
        /**
         * @var Response $response
         */
        $response = (new Bootstrap(App::class, $config))
            ->addAppMiddleware()
            ->addAppRoutes()
            ->run(true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('html', $response->getHeaderLine('content-type'));
        $this->assertContains('<title>Sample</title>', (string)$response->getBody());
    }
}
