<?php
// Override app config with test settings
$config = require_once __DIR__ . '/../../src/config/config.php';
// Disable logger
$config['logger'] = function () {
    return new \Psr\Log\NullLogger();
};


return $config;
