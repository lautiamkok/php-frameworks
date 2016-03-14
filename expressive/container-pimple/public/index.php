<?php
//@ ref: http://zend-expressive.readthedocs.org/en/stable/container/pimple/
chdir(dirname(__DIR__));
require 'vendor/autoload.php';
$container = require 'config/services.php';
$app = $container->get('Zend\Expressive\Application');

$app->route('/', function ($request, $response, $next) {
    $response->getBody()->write('Hello, world!');
    return $response;
});

$app->route('/hello/{name}', function ($request, $response, $next) {
    $name = $request->getAttribute('name');
    $response->getBody()->write('Hello, ' . $name);
    return $response;
});

$app->run();
