<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\Slim();

// Config.
// @ ref: http://docs.slimframework.com/configuration/settings/
$app->config(array(
    'templates.path' => './template/',
));

// Routes:
$app->get('/hello/:name', function ($name) use ($app) {

    // Overwrite response body
    $app->response->setBody("Hello, " . $name);

    // Append response body
    $app->response->write('Bar');

    // Fetch the response object’s body
    $body = $app->response->getBody();
    //var_dump($body);

    // Change the HTTP response headers
    $app->response->headers->set('Content-Type', 'application/json');

    // Fetch headers from the response object's headers property
    $contentType = $app->response->headers->get('Content-Type');
    //var_dump($contentType);
});

// Use multipart/form-data for testing.
// @ref: http://docs.slimframework.com/request/variables/
$app->put('/books/:id', function ($id) use ($app) {
    // Update book identified by $id.
    $allPutVars = $app->request->put();
    $title = $app->request->put('title');
    $content = $app->request->put('content');

    $request = $app->request;
    $body = $request->getBody();
});

// Use application/x-www-form-urlencoded for testing.
// @ref: http://docs.slimframework.com/routing/post/
// @ref: http://docs.slimframework.com/request/variables/
$app->post('/book', function () use ($app) {
    //Create book.
    $allPostVars = $app->request->post();
    $title = $app->request->post('title');
    $content = $app->request->post('content');
});

// Use application/x-www-form-urlencoded for testing.
// @ref: http://docs.slimframework.com/routing/delete/
// @ref: http://docs.slimframework.com/request/variables/
$app->delete('/books/:id', function ($id) use ($app) {
    //Delete book identified by $id.
});

// @ref: http://help.slimframework.com/discussions/problems/4400-templatespath-doesnt-change
$app->notFound(function () use ($app) {
    // You can set the template path here too.
    //$view = $app->view();
    //$view->setTemplatesDirectory('./public/template/');
    $app->render('404.html');
});

$app->run();
