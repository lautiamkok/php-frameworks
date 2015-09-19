<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/source/core/RouteFetcher.php';

define ('WEBSITE_DOCROOT', str_replace('\\', '/', dirname( __FILE__ )).'/');

$app = new \Slim\Slim();

// Config.
// @ ref: http://docs.slimframework.com/configuration/settings/
$app->config(array(
    'templates.path' => './public/template/',
));

// Hope page.
$app->get('/e', function () {
    echo "Hello World!";
});

// Greeting page.
$app->get('/hello/:name', function ($name) {
    echo "Hello, " . $name;
});

// Note found page.
// @ref: http://help.slimframework.com/discussions/problems/4400-templatespath-doesnt-change
$app->notFound(function () use ($app) {
    // You can set the template path here too.
    //$view = $app->view();
    //$view->setTemplatesDirectory('./public/template/');
    $app->render('404.html');
});

// Include the routes manually.
//require __DIR__ . '/module/Admin/Article/config/route.php';
//require __DIR__ . '/module/Admin/Book/config/route.php';

// Or use the route include class.
$RouteFetcher = new RouteFetcher($app);

// Include routes.
$RouteFetcher->fetch([
    'Book/',
    'Admin/Article/',
    'Admin/Book/'
]);

$app->run();
