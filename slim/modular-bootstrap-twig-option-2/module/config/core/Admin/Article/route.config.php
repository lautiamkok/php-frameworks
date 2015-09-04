<?php

// API group
$app->group('/api', function () use ($app) {

    // Admin group
    $app->group('/admin', function () use ($app) {

        // Get article with ID
        $app->get('/articles/:id', function ($id) use ($app) {
            // Update book identified by $id.
            $allPutVars = $app->request->get();
            $title = $app->request->get('title');
            $content = $app->request->get('content');
            print_r($id);
            print_r($allPutVars);
            print_r($title);
            print_r($content);
        });

        // Update article with ID
        $app->put('/articles/:id', function ($id) use ($app) {
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
