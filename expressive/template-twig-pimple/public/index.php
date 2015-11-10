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

$app->route('/hello/{name}', function ($request, $response, $next) use ($app) {
    // Get the name.
    $name = $request->getAttribute('name');

    // Get the container.
    $container = $app->getContainer();

    // Inspect methods for PSR 7:
    // print_r(get_class_methods($request));
    // print_r(get_class_methods($response));

    // Get an instance of Zend TwigRenderer.
    $renderer = $container->get('TwigRenderer');

    // Add the module template and additional paths to the existing.
    $renderer->addPath(__DIR__ . '/views/theme/default/');

    // Store the content.
    $content = $renderer->render('profile.twig', [
        'name'  => $name
    ]);

    $response->getBody()->write($content);
    return $response;
});

$app->run();
