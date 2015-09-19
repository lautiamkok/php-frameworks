<?php

// API group
$app->group('/api', function () {

    // Admin group
    $this->group('/admin', function () {

        // Get article with ID
        $this->get('/articles/{id}', function ($request, $response, $args) {
            // Update book identified by $id.
            $id = $request->getAttribute('id');
            print_r($id);
        });

        // Update article with ID
        $this->put('/articles/{id}', function ($request, $response, $args) {
            // Update book identified by $id.
            $id = $request->getAttribute('id');
            print_r($id);
        });
    });
});
