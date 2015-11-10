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

$container->setFactory('Twig', function ($container) {
    return 'Twig Object';
});

$app = AppFactory::create($container);

$app->get('/', 'HelloWorld');
$app->get('/ping', 'Ping');
$app->get('/twig', function ($request, $response, $next) use ($app) {
    $container = $app->getContainer();

    // Inspect methods for PSR 7:
    // print_r(get_class_methods($request));
    // print_r(get_class_methods($response));

    // @ref: http://stackoverflow.com/questions/18865569/how-to-create-a-factory-in-zend-framework-2
    // @ref: http://codingexplained.com/coding/php/zend-framework/zend-framework-2-service-manager
    $json = json_encode('Hello, ' . $container->get('Twig'));
    $response->getBody()->write($json);
    return $response->withHeader('Content-type', 'application/json');
});

$app->run();
