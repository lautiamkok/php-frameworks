<?php

// @ ref: http://akrabat.com/accessing-services-in-slim-3/

// All of Slim's services are in the container, so where I've used books in this example,
// you can access anything that Slim has registered, such as settings or router and
// in addition to what you have registered yourself.

use Slim\App as Slim;
use Slim\Http\Request;
use Slim\Http\Response;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/BookMapper.php';
require_once __DIR__ . '/../src/HomeAction.php';

$settings = require __DIR__ . '/../config/settings.php';

$app = new Slim($settings);

// Get the Slim container.
$container = $app->getContainer();

// Setup the container.
$container['pdo'] = function ($container) {
    $cfg = $container->get('settings')['db'];
    return new \PDO($cfg['dsn'], $cfg['user'], $cfg['password']);
};

// Let's start by setting up the container with a fictional mapper:
$container['books'] = function ($container) {
    return new BookMapper($container->get('pdo'));
};

$container['HomeAction'] = function ($container) {
    return new HomeAction($container->get('books'));
};

// A route callable closure:
$app->get('/', function (Request $request, Response $response, array $args) {

    // If you use a closure, then Slim binds the application instance to $this.
    $books = $this->getContainer()->get('books');

    // There's also a shortcut you can use as App implements __get which proxies to the container object's get method:
    // Retrieve from the container.
    // $books = $this->books;

    // Render the template using a simple content variable.
    return $response->write('Hello World!');

})->setName('hello-world');

// A route callable class:
// If you use a class method for a route callable like this:
// Slim will look for a DI key of HomeAction, use the DI container to instantiate the class and
// then dispatch by calling the dispatch() method.
$app->get('/home', 'HomeAction:dispatch');

$app->run();
