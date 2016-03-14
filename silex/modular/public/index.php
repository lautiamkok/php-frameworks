<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../source/core/RouteFetcher.php';

// Set website public documentroot.
define ('WEBSITE_DOCROOT', str_replace('\\', '/', dirname(__FILE__)) .'/');

$app = new Silex\Application();

$app->get('/', function() use ($app) {
    return 'Hello World!';
});

$app->get('/hello/{name}', function($name) use ($app) {
    return 'Hello ' . $app->escape($name);
});

// Include the routes manually.
// require __DIR__ . '/../module/Admin/Article/config/route.config.php';
// require __DIR__ . '/../module/Admin/Book/config/route.config.php';

// Or use the route include class.
$RouteFetcher = new RouteFetcher($app);

// Include routes.
$RouteFetcher->fetch([
    'Book/',
    'Admin/Article/',
    'Admin/Book/'
]);

$app->run();
