<?php

// @ref: http://www.slimframework.com/docs/objects/request.html#the-request-uri
// @usage: http://localhost/php-frameworks/slim/slim-3/modular/public/books/1?title=hello&content=world
$app->get('/books/{id}', function ($request, $response, $args) {
    // Update book identified by $id.
    $id = $request->getAttribute('id');
    print_r($id);

    // Get all get/put/post parameters:
    // GET
    $allGetVars = $request->getQueryParams();
    $title = $allGetVars['title'];
    $content = $allGetVars['content'];
    print_r($allGetVars);
    print_r($title);
    print_r($content);
});

// Use application/x-www-form-urlencoded for testing.
// @ref: http://www.slimframework.com/docs/objects/request.html#the-request-body
// @usage: http://localhost/php-frameworks/slim/slim-3/modular/public/books/1
$app->put('/books/{id}', function ($request, $response, $args) {
    // Update book identified by $id.
    $id = $request->getAttribute('id');
    print_r($id);

    // Get all get/put/post parameters:
    // POST or PUT
    $allPostPutVars = $request->getParsedBody();
    $title = $allPostPutVars['title'];
    $content = $allPostPutVars['content'];
    print_r($allPostPutVars);
    print_r($title);
    print_r($content);
});

// Use multipart/form-data for testing.
// @ref: http://www.slimframework.com/docs/objects/request.html#the-request-body
// @usage: http://localhost/php-frameworks/slim/slim-3/modular/public/books
$app->post('/books', function ($request, $response, $args) {
    // Create book.
    // Get all get/put/post parameters:
    // POST or PUT
    $allPostPutVars = $request->getParsedBody();
    $title = $allPostPutVars['title'];
    $content = $allPostPutVars['content'];
    print_r($allPostPutVars);
    print_r($title);
    print_r($content);
});

// Use application/x-www-form-urlencoded for testing.
// @usage: http://localhost/php-frameworks/slim/slim-3/modular/public/books/1
$app->delete('/books/{id}', function ($request, $response, $args) {
    //Delete book identified by $id.
    $id = $request->getAttribute('id');
    print_r($id);
});
