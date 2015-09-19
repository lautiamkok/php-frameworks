<?php

// API group
$app->group('/api', function () use ($app) {

    // Admin group
    $app->group('/admin', function () use ($app) {

        // Get book with ID
        $app->get('/books/:id', function ($id) use ($app) {
            // Update book identified by $id.
            $allPutVars = $app->request->get();
            $title = $app->request->get('title');
            $content = $app->request->get('content');
            print_r($id);
            print_r($allPutVars);
            print_r($title);
            print_r($content);
        });

        // Update book with ID
        $app->put('/books/:id', function ($id) use ($app) {
            // Update book identified by $id.
            $allPutVars = $app->request->put();
            $title = $app->request->put('title');
            $content = $app->request->put('content');
            print_r($id);
            print_r($allPutVars);
            print_r($title);
            print_r($content);
        });

        // Delete book with ID
        $app->delete('/books/:id', function ($id) use ($app) {
            // Update book identified by $id.
            $allPutVars = $app->request->put();
            $title = $app->request->put('title');
            $content = $app->request->put('content');
            print_r($id);
            print_r($allPutVars);
            print_r($title);
            print_r($content);
        });

    });

});
