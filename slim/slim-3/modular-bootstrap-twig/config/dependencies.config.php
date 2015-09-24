<?php

use Slim\Views\Twig;
use Barium\PageNotFound\View\NotFoundHandler;

// DIC configuration
$container = $app->getContainer();

// Twig
$container['view'] = function ($container) {
    $settings = $container->get('settings');
    $view = new Twig($settings['view']['template_path'], $settings['view']['twig']);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $container->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

$container['notFoundHandler'] = function ($container) {

    return new NotFoundHandler($container->get('view'), $container->get('settings'), function ($request, $response) use ($container) {
        return $container['response']
            ->withStatus(404);
    });
};
