<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$config = require_once __DIR__ . '/../../src/config/config.php';

(new \App\Bootstrap(\Slim\App::class, $config))
    ->addAppDependencies()
    ->addAppMiddleware()
    ->addAppRoutes()
    ->run();
