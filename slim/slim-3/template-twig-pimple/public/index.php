<?php

use Slim\Http\Request;
use Slim\Http\Response;

require_once __DIR__ . '/../vendor/autoload.php';

// @ref: http://www.slimframework.com/docs/features/templates.html
// Create container
// $container = new \Slim\Container;

// Prepare the Pimple dependency injection container.
$container = new \Slim\Container([
  'site_name' => 'Slim Shady',
]);

// Register component on container
// Add a Twig service to the container.
$container['twig'] = function($container) {
    $loader = new Twig_Loader_Filesystem('template/');
    return new Twig_Environment($loader, array('cache'));
};

$app = new \Slim\App($container);

// Routes:
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {

    // Load the template through the Twig service in the DIC.
    $template = $this->getContainer()->get('twig')->loadTemplate('profile.twig');

    // Render the template using a simple content variable.
    return $response->write($template->render([
        'name' => $args['name'],
        // 'site_name' => $this->settings['site_name'], // does not work
        'site_name' => $this->getContainer()->get('site_name')
    ]));

})->setName('greeting');

$app->run();
