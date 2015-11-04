<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Barium\Admin\Middleware\AuthMiddleware;

// API group
$app->group('/api', function () {

    // Admin group
    $this->group('/admin', function () {
        // Get article with ID
        $this->get('/articles', function (Request $request, Response $response, array $args) {
            $response->getBody()->write('Hello Admin');
            return $response;
        });

        // Get article with ID
        $this->get('/articles/{id}', function (Request $request, Response $response, array $args) {
            // Update book identified by $id.
            $id = $request->getAttribute('id');
            print_r($id);
        });

        // Update article with ID
        $this->put('/articles/{id}', function (Request $request, Response $response, array $args) {
            // Update book identified by $id.
            $id = $request->getAttribute('id');
            print_r($id);
        });
    });

})->add(new AuthMiddleware());
// })->add(function ($request, $response, $next) {
//     $response->getBody()->write('It is now ');
//     $response = $next($request, $response);
//     $response->getBody()->write('. Enjoy!');

//     return $response;
// });
