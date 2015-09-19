<?php

// API group
// @ ref: http://www.slimframework.com/docs/objects/router.html#how-to-create-routes
$app->group('/api', function () {

    $this->group('/admin', function () {

        $this->get('/reset-password', function ($request, $response, $args) {
            // Reset the password for user identified by $args['id']
        })->setName('user-password-reset');

        // Get book with ID
        $this->get('/books/{id}', function ($request, $response, $args) {
            // Get book identified by $id.
            $id = $request->getAttribute('id');
            print_r($id);
        });

        // Update book with ID
        $this->put('/books/{id}', function ($request, $response, $args) {
            // Update book identified by $id.
            $id = $request->getAttribute('id');
            print_r($id);
        });

        // Delete book with ID
        $this->delete('/books/{id}', function ($request, $response, $args) {
            // Delete book identified by $id.
            $id = $request->getAttribute('id');
            print_r($id);
        });

    });

});
