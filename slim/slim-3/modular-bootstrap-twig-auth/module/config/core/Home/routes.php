<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Hope page.
$app->get('/', function (Request $request, Response $response, array $args) {
    // Get the application settings.
    $settings = $this->get('settings');

    // Check if the home page result file is provided.
    if (isset($settings['home_page']['result']) && !empty($settings['home_page']['result'])) {
        return require_once APPLICATION_ROOT . 'module/result/' . $settings['home_page']['result'];
    } else {
        $response->getBody()->write('Hello World!');
        return $response->withHeader('Content-type', 'application/json');
    }
});
