<?php

// Include application bootstrap.
require_once __DIR__ . '/../bootstrap.php';

// Set website public documentroot.
define ('WEBSITE_DOCROOT', str_replace('\\', '/', dirname(__FILE__)) .'/');

// Get an instance of Slim.
use \Slim\Slim;
$app = new Slim();

// Configure the application.
$app->config(array(
    // Global template path
    'templates.path' => '../public/template/',

    // Application configuration.
    'application' => require '../config/application.config.php'
));

// Hope page.
$app->get('/', function () use ($app) {
    echo "Hello World!";
});

// Fetch the routes.
$RouteFetcher = new RouteFetcher($app);

// Include routes.
$RouteFetcher->fetch([
    // '404' => [
    //     'path' => [
    //         'direction' => 'local/',
    //         'module' => '404/'
    //     ]
    // ],
    '404/',
    'Book/',
    'Admin/Article/',
    'Admin/Book/'
]);

// Run the application!
$app->run();
