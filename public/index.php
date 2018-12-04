<?php
require_once  __DIR__ .'/../vendor/autoload.php';

$config = require_once __DIR__ . '/../src/config/';
(new \App\Bootstrap(\Slim\App::class, $config))
    ->addAppMiddleware()
    ->addAppRoutes()
    ->run();