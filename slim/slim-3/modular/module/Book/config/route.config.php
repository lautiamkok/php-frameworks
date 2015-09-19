<?php

// Use multipart/form-data for testing.
// @ref: http://docs.slimframework.com/request/variables/{
$app->put('/books/{id}', function ($request, $response, $args) {
    // Update book identified by $id.
    $id = $request->getAttribute('id');
    print_r($id);
});

// Use application/x-www-form-urlencoded for testing.
// @ref: http://docs.slimframework.com/routing/post/
// @ref: http://docs.slimframework.com/request/variables/
$app->post('/books', function ($request, $response, $args) {
    //Create book.
    // $allPostVars = $app->request->post();
    // $title = $app->request->post('title');
    // $content = $app->request->post('content');
    // print_r($allPostVars);
    // print_r($title);
    // print_r($content);
    print_r($_POST);
});

// Use application/x-www-form-urlencoded for testing.
// @ref: http://docs.slimframework.com/routing/delete/
// @ref: http://docs.slimframework.com/request/variables/
$app->delete('/books/{id}', function ($request, $response, $args) {
    //Delete book identified by $id.
    $id = $request->getAttribute('id');
    print_r($id);
});
