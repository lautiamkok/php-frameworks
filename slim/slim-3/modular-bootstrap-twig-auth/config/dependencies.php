<?php
use Slim\Views\Twig;
use Spectre\ClientError\NotFound\Controller\NotFoundController;

// DIC configuration
$container = $app->getContainer();

// Twig
$container['view'] = function ($container) {
    // // Option 1: Using Slim's View.
    // $settings = $container->get('settings');
    // $view = new Twig($settings['view']['template_path'], $settings['view']['twig']);

    // // Add extensions
    // $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $container->get('request')->getUri()));
    // $view->addExtension(new Twig_Extension_Debug());

    // return $view;

    // Option 2: Using Twig directly.
    $settings = $container->get('settings');

    $loader = new Twig_Loader_Filesystem($settings['view']['template_path']);
    return new Twig_Environment($loader, array('cache'));
};

// Register 404 page when the request route is not found.
$container['notFoundHandler'] = function ($container) {
    return new NotFoundController($container);
};
