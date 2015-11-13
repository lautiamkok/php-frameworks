<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Hope page.
$app->get('/', function (Request $request, Response $response, array $args) {

    // Get the container that stored in Slim\App.
    $container = $this->getContainer();

    // Get the application settings.
    $settings = $container->get('settings');

    // Check if the home page bootstrap file is provided.
    if ($settings['home_page']['bootstrap']) {
        return require_once APPLICATION_ROOT . 'module/bootstrap/' . $settings['home_page']['bootstrap'];
    } else {
        $response->getBody()->write('Hello World!');
        return $response->withHeader('Content-type', 'application/json');
    }
});
