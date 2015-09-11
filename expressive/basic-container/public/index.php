<?php

use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\AppFactory;
use Zend\ServiceManager\ServiceManager;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = new ServiceManager();

$container->setFactory('HelloWorld', function ($container) {
    return function ($req, $res, $next) {
        $res->write('Hello, world!');
        return $res;
    };
});

$container->setFactory('Ping', function ($container) {
    return function ($req, $res, $next) {
        return new JsonResponse(['ack' => time()]);
    };
});

$app = AppFactory::create($container);

$app->get('/', 'HelloWorld');
$app->get('/ping', 'Ping');

$app->run();
