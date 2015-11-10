<?php

use Zend\Expressive\AppFactory;
use Zend\ServiceManager\ServiceManager;
use Zend\Expressive\Twig\TwigRenderer;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = new ServiceManager();

$container->setFactory('TwigRenderer', function ($container) {
    // Create the engine instance:
    // $loader = new Twig_Loader_Array(include 'config/templates.php');
    $loader = new Twig_Loader_Filesystem(include 'config/templates.php');
    $twig = new Twig_Environment($loader);

    // // Configure it:
    // // $twig->addExtension(new CustomExtension());
    // // $twig->loadExtension(new CustomExtension();

    // Inject:
    return new TwigRenderer($twig);
});

$app = AppFactory::create($container);

$app->get('/', function ($request, $response, $next) {
    $response->getBody()->write('Hello, world!');
    return $response;
});

$app->get('/books/{id}', function ($request, $response, $next) {
    // fetch the id attribute to discover what was matched:
    $id = $request->getAttribute('id');
    $response->getBody()->write('Book ID: ' . $id);
    return $response;
});

$app->get('/hello/{name}', function ($request, $response, $next) use ($app) {

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
