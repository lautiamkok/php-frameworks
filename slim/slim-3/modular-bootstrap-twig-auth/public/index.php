<?php

// Import classes.
use Slim\App as Slim;
// use Slim\Views\Twig;
use Barium\RouteFetcher;

// Include application bootstrap.
chdir(dirname(__DIR__));
require 'bootstrap.php';

// Or:
// require_once __DIR__ . '/../bootstrap.php';
// With this option, you must have ../ in all your paths, for instance:
// 'templates.path' => '../public/theme/default/',
// 'application' => require '../config/application.php',

// Set website public documentroot.
define ('WEBSITE_DOCROOT', str_replace('\\', '/', dirname(__FILE__)) .'/');

// $settings = [
//     // Application settings.
//     'settings' => require 'config/application.php',

//     // View settings.
//     // Prepare view with Twig.
//     'view' => new Twig('public/theme/default/', [
//         //'cache' => 'cache/twig/',
//         'debug' => true,
//         'auto_reload' => true,
//     ]),

//     'notFoundHandler' => function ($container) {
//         return function ($request, $response) use ($container) {
//             return $container['view']->render($response, 'PageNotFound/index.html', [
//                 "myMagic" => "Let's roll"
//             ])->withStatus(404);
//         };
//     }
// ];

// Or:
// Get the application settings file.
$settings = require 'config/application.php';

// Get an instance of Slim.
$app = new Slim($settings);

// Set up dependencies.
require 'config/dependencies.php';

// Get an instance of RouteFetcher.
$RouteFetcher = new RouteFetcher($app);

// Fetch the routes.
$RouteFetcher->fetch();

// Run the application!
$app->run();
