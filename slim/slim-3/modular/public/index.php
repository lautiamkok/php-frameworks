<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../source/core/RouteFetcher.php';

define ('WEBSITE_DOCROOT', str_replace('\\', '/', dirname( __FILE__ )).'/');

$app = new \Slim\App();

// Hope page.
$app->get('/', function ($request, $response, $args) {
    echo "Hello World!";
});

// Greeting page.
$app->get('/hello/{name}', function ($request, $response, $args) {

    // fetch the id attribute to discover what was matched.
    $name = $request->getAttribute('name');

    $status = $response->getStatusCode();
    //var_dump($status);

    //echo 'Hello, ' . $name;
    $response->getBody()->write('Hello, ' . $name);
    return $response->withHeader('Content-type', 'application/json');

});

// Include the routes manually.
//require __DIR__ . '/module/Admin/Article/config/route.config.php';
//require __DIR__ . '/module/Admin/Book/config/route.config.php';

// Or use the route include class.
$RouteFetcher = new RouteFetcher($app);

// Include routes.
$RouteFetcher->fetch([
    'Book/',
    'Admin/Article/',
    'Admin/Book/'
]);

$app->run();
