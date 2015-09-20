<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App();

// Routes:
$app->get('/hello/{name}', function ($request, $response, $args) {

    // fetch the id attribute to discover what was matched.
    $name = $request->getAttribute('name');

    // $response->getBody()->write('Hello, ' . $name);
    // return $response->withHeader('Content-type', 'application/json');

    return require_once __DIR__ . '/hello.php';

});

$app->run();
