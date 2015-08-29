<?php

// Get book with ID
$app->get('/books/:id', function ($id) use ($app) {
    // Update book identified by $id.
    $allPutVars = $app->request->get();
    $title = $app->request->get('title');
    $content = $app->request->get('content');

    // Get the bootstrap.
    require_once APPLICATION_ROOT . 'module/Book/bootstrap/index.php';

    $view = $app->view();
    $view->setTemplatesDirectory(APPLICATION_ROOT . 'module/Book/view/');
    $app->render('index.phtml', array(
        'id' => $id,
        'title' => $title,
        'content' => $content
    ));
});

// Use multipart/form-data for testing.
// @ref: http://docs.slimframework.com/request/variables/
$app->put('/books/:id', function ($id) use ($app) {
    // Update book identified by $id.
    $allPutVars = $app->request->put();
    $title = $app->request->put('title');
    $content = $app->request->put('content');
    print_r($id);
    print_r($allPutVars);
    print_r($title);
    print_r($content);

    $view = $app->view();
    $view->setTemplatesDirectory(APPLICATION_ROOT . 'module/Book/view/');
    $app->render('index.phtml', array(
        'id' => $id,
        'title' => $title,
        'content' => $content
    ));
});

// Use application/x-www-form-urlencoded for testing.
// @ref: http://docs.slimframework.com/routing/post/
// @ref: http://docs.slimframework.com/request/variables/
$app->post('/books', function () use ($app) {
    //Create book.
    $allPostVars = $app->request->post();
    $title = $app->request->post('title');
    $content = $app->request->post('content');
    print_r($allPostVars);
    print_r($title);
    print_r($content);
});

// Use application/x-www-form-urlencoded for testing.
// @ref: http://docs.slimframework.com/routing/delete/
// @ref: http://docs.slimframework.com/request/variables/
$app->delete('/books/:id', function ($id) use ($app) {
    //Delete book identified by $id.
    print_r($id);
});
