<?php

return [
    'routes' => [
        [
            'path' => '/',
            'middleware' => 'Application\HelloWorld',
            'allowed_methods' => [ 'GET' ],
        ],
        [
            'path' => '/ping',
            'middleware' => 'Application\Ping',
            'allowed_methods' => [ 'GET' ],
        ],
    ],
];
