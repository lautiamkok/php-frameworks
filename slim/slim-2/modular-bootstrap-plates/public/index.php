<?php

// Include application bootstrap.
require_once __DIR__ . '/../bootstrap.php';

// Set website public documentroot.
define ('WEBSITE_DOCROOT', str_replace('\\', '/', dirname(__FILE__)) .'/');

// Import classes.
use Slim\Slim;
use Barium\RouteFetcher;

// Get an instance of Slim.
$app = new Slim();

// Configure the application.
$app->config(array(
    // Global template path
    'templates.path' => '../public/template/',

    // Application configuration.
    'application' => require '../config/application.config.php',

    // Prepare view with Plate.
    //'view' => new Plate('../public/template/')
));

// Get an instance of RouteFetcher.
$RouteFetcher = new RouteFetcher($app);

// Fetch the routes.
$RouteFetcher->fetch();

// Run the application!
$app->run();
