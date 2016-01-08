<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Barium\Admin\Middleware\AuthMiddleware;

// API group
$app->group('/api', function () {

    // Access admin area.
    $this->get('/admin', function (Request $request, Response $response, array $args) {
        $response->getBody()->write('Hello Admin');
        return $response;
    });

})->add(new AuthMiddleware());
