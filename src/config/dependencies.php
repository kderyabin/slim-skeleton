<?php
use \Psr\Container\ContainerInterface;

return [
    'renderer' =>  function (ContainerInterface $ci) {
        $settings = $ci->get('settings')['renderer'];
        return new Slim\Views\PhpRenderer($settings['template_path']);
    },
    'logger' =>function (ContainerInterface $ci) {
        return new \Kod\Logger([
            'message' => [
                'fields' => [
                    'request_id' => $_SERVER['HTTP_X_REQUEST_ID'] ?? bin2hex(random_bytes(10)),
                    'remote_ip' => $_SERVER['REMOTE_ADDR'],
                ]
            ],
        ]);
    }
];
