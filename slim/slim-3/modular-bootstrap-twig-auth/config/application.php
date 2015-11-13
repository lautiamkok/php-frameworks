<?php

// use Slim\Views\Twig;

return [
    // Application configuration.
    'settings' => [
        // The home page can be set to any module,
        // for example:'local/Home/index.php','core/Article/index.php'
        // Otherwise it will fall back to the default message: 'Hello World!'
        // when no bootstrap is provided.
        'home_page' => [
            'bootstrap' => 'core/Home/index.php'
        ],

        'database' => [
            'core' => 'config/core/database.php',
            'local' => 'config/local/database.php'
        ],

        'modules' => [
            'core' => 'config/core/modules.php',
            'local' => 'config/local/modules.php'
        ],

        'directories' => [
            'core' => 'config/core/directories.php',
            'local' => 'config/local/directories.php'
        ],

        // View settings.
        // Prepare view for Twig.
        'view' => [
            'template_path' => 'public/theme/default/',
            'twig' => [
                'cache' => 'cache/twig/',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],
    ],

    // Or:
    // // View settings.
    // // Prepare view with Twig.
    // 'view' => new Twig('public/theme/default/', [
    //     //'cache' => 'cache/twig/',
    //     'debug' => true,
    //     'auto_reload' => true,
    // ]),

    // Custom 404 page.
    // Ref: http://help.slimframework.com/discussions/problems/10851-how-to-add-404-template-in-slim-3
    // Or:
    // 'notFoundHandler' => function ($container) {
    //     return function ($request, $response) use ($container) {
    //         return $container['view']->render($response, 'PageNotFound/index.html', [
    //             "myMagic" => "Let's roll"
    //         ])->withStatus(404);
    //     };
    // }
];
