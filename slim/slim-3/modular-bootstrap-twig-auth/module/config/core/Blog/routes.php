<?php
// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

use Spectre\Blog\Controller\BlogController;

// Blog home page.
$app->get('/blog', function (Request $request, Response $response, array $args) {
    // Get the result via the controller.
    $controller = new BlogController($this);
    $controller($request, $response, $args);
});
