<?php

// Very basic!
use Zend\Expressive\AppFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$app = AppFactory::create();

$app->route('/', function ($request, $response, $next) {
    $response->getBody()->write('Hello, world!');
    return $response;
});

$app->route('/hello/{name}', function ($request, $response, $next) {
    $name = $request->getAttribute('name');
    $response->getBody()->write('Hello, ' . $name);
    return $response;
});

$app->post('/post', function ($req, $res, $next) {
    $res->write('IN POST!');
    return $res;
});

$app->run();

// // With FastRoute.
// // @ref: http://zend-expressive.readthedocs.org/en/stable/router/fast-route/
// use FastRoute;
// use FastRoute\Dispatcher\GroupPosBased as FastRouteDispatcher;
// use FastRoute\RouteCollector;
// use FastRoute\RouteGenerator;
// use FastRoute\RouteParser\Std as RouteParser;
// use Zend\Expressive\AppFactory;
// use Zend\Expressive\Router\FastRouteRouter as FastRouteBridge;

// chdir(dirname(__DIR__));
// require 'vendor/autoload.php';

// $fastRoute = new RouteCollector(
//     new RouteParser(),
//     new RouteGenerator()
// );
// $getDispatcher = function ($data) {
//     return new FastRouteDispatcher($data);
// };

// $router = new FastRouteBridge($fastRoute, $getDispatcher);

// $app = AppFactory::create(null, $router);

// $app->route('/', function ($request, $response, $next) {
//     $response->getBody()->write('Hello, world!');
//     return $response;
// });

// $app->route('/hello/{name}', function ($request, $response, $next) {
//     $name = $request->getAttribute('name');
//     $response->getBody()->write('Hello, ' . $name);
//     return $response;
// });

// $app->post('/post', function ($req, $res, $next) {
//     $res->write('IN POST!');
//     return $res;
// });

// $app->run();
