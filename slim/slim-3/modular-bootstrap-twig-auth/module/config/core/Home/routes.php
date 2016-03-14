<?php
// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

// Hope page.
$app->get('/', function (Request $request, Response $response, array $args) {
    // Get the application settings.
    $settings = $this->get('settings');

    // Check if the home page class is provided.
    if (isset($settings['home_page']['class']) && !empty($settings['home_page']['class'])) {
        // Get the result via the page controller.
        $controller = new $settings['home_page']['class']($this);
        $controller($request, $response, $args);
        return $response->withHeader('Content-type', 'application/json');
    } else {
        $response->getBody()->write('Fallback Hello World!');
        return $response->withHeader('Content-type', 'application/json');
    }
});
