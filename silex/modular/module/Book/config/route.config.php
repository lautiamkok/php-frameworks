<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Get book with ID
$app->get('/books/{id}', function ($id, Request $request) use ($app) {
    // Update book identified by $id.
    $title = $request->get('title');
    $content = $request->get('content');
    print_r($id);
    print_r($title);
    print_r($content);

    return new Response('', 200);
});


// Use multipart/form-data for testing.
// @ref: http://docs.slimframework.com/request/variables/
$app->put('/books/{id}', function ($id, Request $request) use ($app) {
    // Update book identified by $id.
    $title = $request->get('title');
    $content = $request->get('content');
    print_r($id);
    print_r($title);
    print_r($content);

    return new Response('', 200);
});

// Use application/x-www-form-urlencoded for testing.
// @ref: http://docs.slimframework.com/routing/post/
// @ref: http://docs.slimframework.com/request/variables/
$app->post('/books', function (Request $request) use ($app) {
    //Create book.
    $title = $request->get('title');
    $content = $request->get('content');
    print_r($title);
    print_r($content);

    return new Response('', 200);
});

// Use application/x-www-form-urlencoded for testing.
// @ref: http://docs.slimframework.com/routing/delete/
// @ref: http://docs.slimframework.com/request/variables/
$app->delete('/books/{id}', function ($id, Request $request) use ($app) {
    //Delete book identified by $id.
    print_r($id);
    return new Response('', 200);
});
