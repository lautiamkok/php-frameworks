<?php
// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

use Barium\Admin\Middleware\AuthMiddleware;

// Access admin area.
$app->get('/admin', function (Request $request, Response $response, array $args) {
    $response->getBody()->write('Hello Admin');
    return $response;
})->add(new AuthMiddleware());
