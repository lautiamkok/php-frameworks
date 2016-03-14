<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// API group
// Get article with ID
$app->get('/admin/articles/{id}', function ($id, Request $request) use ($app) {
    // Update book identified by $id.
    $title = $request->get('title');
    $content = $request->get('content');
    print_r($id);
    print_r($title);
    print_r($content);

    return new Response('', 200);
});

// Update article with ID
$app->put('/admin/articles/{id}', function ($id, Request $request) use ($app) {
    // Update book identified by $id.
    $title = $request->get('title');
    $content = $request->get('content');
    print_r($id);
    print_r($title);
    print_r($content);

    return new Response('', 200);
});
