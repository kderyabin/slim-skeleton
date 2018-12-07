<?php
/**
 * Customize theses settings as you wish
 */
use \Psr\Container\ContainerInterface;

// dependencies
return [
    'renderer' => function (ContainerInterface $ci) {
        $settings = $ci->get('settings')['renderer'];
        return new Slim\Views\PhpRenderer($settings['template_path']);
    },
    'logger' => function (ContainerInterface $ci) {
        return new \Kod\Logger([
            'message' => [
                'fields' => [
                    'request_id' => $_SERVER['HTTP_X_REQUEST_ID'] ?? bin2hex(random_bytes(10)),
                    'remote_ip' => $_SERVER['REMOTE_ADDR'],
                ]
            ],
            'channels' => [
                [
                    'handler' => [
                        // Checking for CLI Web Server Use
                        'path' => php_sapi_name() === 'cli-server'
                            ? 'php://stdout'
                            : __DIR__ . '/../../var/debug.log',
                    ],
                ],
            ],
        ]);
    }
];
