<?php
// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

use Barium\Blog\PageController\BlogPageController;

// Blog home page.
$app->get('/blog', function (Request $request, Response $response, array $args) {
    // Get the result via the page controller.
    $controller = new BlogPageController($this);
    $controller($request, $response, $args);
});
