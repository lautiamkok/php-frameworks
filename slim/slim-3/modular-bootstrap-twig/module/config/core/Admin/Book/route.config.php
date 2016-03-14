<?php

use Slim\Http\Request;
use Slim\Http\Response;

// API group
$app->group('/api', function () {

    $this->group('/admin', function () {

        // Get book with ID
        $this->get('/books/{id}', function (Request $request, Response $response, array $args) {
            // Get book identified by $id.
            $id = $request->getAttribute('id');
            print_r($id);
        });

        // Update book with ID
        $this->put('/books/{id}', function (Request $request, Response $response, array $args) {
            // Update book identified by $id.
            $id = $request->getAttribute('id');
            print_r($id);
        });

        // Delete book with ID
        $this->delete('/books/{id}', function (Request $request, Response $response, array $args) {
            // Delete book identified by $id.
            $id = $request->getAttribute('id');
            print_r($id);
        });

    });

});
