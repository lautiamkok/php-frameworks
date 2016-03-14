<?php

use Symfony\Component\HttpFoundation\Request;

// Hope page.
$app->get('/', function (Request $request) use ($app) {

    // Get the application settings.
    $settings = $app['settings']['settings'];

    // Check if the home page bootstrap file is provided.
    if ($settings['home_page']['bootstrap']) {
        return require_once APPLICATION_ROOT . 'module/bootstrap/' . $settings['home_page']['bootstrap'];
    } else {
        $response->getBody()->write('Hello World!');
        return $response->withHeader('Content-type', 'application/json');
    }
});
