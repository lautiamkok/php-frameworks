<?php

use Slim\Views\Twig;

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
