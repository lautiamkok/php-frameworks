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

// Get an instance of RouteFetcher.
$RouteFetcher = new Barium\RouteFetcher($app);

// Fetch the routes.
$RouteFetcher->fetch();

// Run the application!
$app->run();