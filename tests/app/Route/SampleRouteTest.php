<?php

namespace App\Tests\app\Route;

use App\Bootstrap;
use App\Route\SampleRoute;
use PHPUnit\Framework\TestCase;
use Slim\App;

class SampleRouteTest extends TestCase
{
    public static $config = [];

    public static function setUpBeforeClass()
    {
        static::$config = require TEST_CONF_DIR . '/config.php';
    }
    /**
     * @testdox Test the SampleRoute only
     */
    public function testSampleRouteAlone()
    {
        $bootstrap = new Bootstrap(App::class, static::$config);
        $bootstrap->addRouteDefinitions(SampleRoute::class);
        $ci = $bootstrap->getContainer();
        $ci->prepareEnv
    }
}
