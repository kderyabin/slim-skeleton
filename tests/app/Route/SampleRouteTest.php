<?php

namespace App\Tests\app\Route;

use App\Bootstrap;
use App\Helper\TUHelper;
use App\Middleware\SampleMiddleware;
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
            TUHelper::prepareRequest('GET', '/')
        );
        /**
         * @var Response $response
         */
        $response = (new Bootstrap(App::class, $config))
            ->addRouteDefinitions(SampleRoute::class)
            ->run(true);

        $this->assertEquals( 200, $response->getStatusCode());
        $this->assertContains( 'html', $response->getHeaderLine('content-type'));
        // without the middleware the title is empty
        $this->assertContains( '<title></title>', (string)$response->getBody());
    }

    /**
     * @testdox Test the SampleRoute output with middleware
     */
    public function testSampleRouteWithMiddleware()
    {
        $config = array_merge(
            static::$config,
            TUHelper::prepareRequest('GET', '/')
        );
        /**
         * @var Response $response
         */
        $response = (new Bootstrap(App::class, $config))
            ->addRouteDefinitions(SampleRoute::class)
            ->addMiddleware(SampleMiddleware::class)
            ->run(true);

        $this->assertEquals( 200, $response->getStatusCode());
        $this->assertContains( 'html', $response->getHeaderLine('content-type'));
        // without the middleware the title is empty
        $this->assertContains( '<title>Sample</title>', (string)$response->getBody());
    }
}
