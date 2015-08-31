<?php

use Symfony\Component\HttpFoundation\Response;
use Nice\Application;
use Nice\Router\RouteCollector;

require __DIR__ . '/../vendor/autoload.php';

// Enable Symfony debug error handlers
Symfony\Component\Debug\Debug::enable();

$app = new Application();

// Configure your routes
$app->set('routes', function (RouteCollector $r) {
    $r->map('/', null, function () {
        return new Response('Hello, world');
    });

    $r->map('/hello/{name}', null, function ($name) {
        return new Response('Hello, ' . $name . '!');
    });
});


// Run the application
$app->run();
