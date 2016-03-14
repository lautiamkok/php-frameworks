<?php

use Slim\App as Slim;
use Slim\Http\Request;
use Slim\Http\Response;

require_once __DIR__ . '/../vendor/autoload.php';

// @ref: http://www.slimframework.com/docs/features/templates.html
// Create container
// $container = new \Slim\Container;

// // Prepare the Pimple dependency injection container.
// $container = new \Slim\Container([
//     'settings' => [
//         'site_name' => 'Slim Shady',
//     ]
// ]);

// // Register component on container
// // Add a Twig service to the container.
// $container['twig'] = function($container) {
//     $loader = new Twig_Loader_Filesystem('template/');
//     return new Twig_Environment($loader, array('cache'));
// };

// $app = new Slim($container);

// Or:
$settings = [
    'settings' => [
        'site_name' => 'Slim Shady',
    ]
];

$app = new Slim($settings);

// Get the Slim container.
$container = $app->getContainer();

// Register component on container
// Add a Twig service to the container.
$container['twig'] = function($container) {

    // Access the settings.
    // For example:
    $site_name = $container->get('settings')['site_name'];

    $loader = new Twig_Loader_Filesystem('template/');
    return new Twig_Environment($loader, array('cache'));
};

// Routes:
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {

    // Load the template through the Twig service in the DIC.
    $template = $this->getContainer()->get('twig')->loadTemplate('profile.twig');

    // Access the settings.
    // For example:
    $site_name = $this->getContainer()->get('settings')['site_name'];

    // Or:
    $site_name = $this->settings['site_name'];

    // Render the template using a simple content variable.
    return $response->write($template->render([
        'name' => $args['name'],
        'site_name' => $this->settings['site_name']
    ]));

})->setName('greeting');

$app->run();
