<?php

use Zend\Expressive\AppFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

//require_once __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->route('/', function ($request, $response, $next) {
    $response->getBody()->write('Hello, world!');
    return $response;
});

$app->route('/books/{id}', function ($request, $response, $next) {
    // fetch the id attribute to discover what was matched:
    $id = $request->getAttribute('id');
    $response->getBody()->write('Book ID: ' . $id);
    return $response;
})->setOptions([
    'tokens' => [ 'id' => '\d+' ],
]);

$app->run();
