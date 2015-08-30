<?php

// Get book with ID
$app->get('/books/:id', function ($id) use ($app) {
    // Update book identified by $id.
    $allGetVars = $app->request->get();
    $title = $app->request->get('title');
    $content = $app->request->get('content');

    print_r($id);
    print_r($allGetVars);
    print_r($title);
    print_r($content);

    // Get the application configuration.
    $applicationConfig = $app->config('application');

    // Get the global & local modules configurations.
    $modulesGlobal = require $applicationConfig['modules']['global'];
    $modulesLocal = require $applicationConfig['modules']['local'];

    // Merge the configurations.
    $modules = array_merge($modulesGlobal, $modulesLocal);

    // Render the view with the data.
    $view = $app->view();
    $view->setTemplatesDirectory(APPLICATION_ROOT . 'module/' . $modules['Book']['path']['direction'] . $modules['Book']['path']['directory'] . 'view/');
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

    // Get the application configuration.
    $applicationConfig = $app->config('application');

    // Get the global & local modules configurations.
    $modulesGlobal = require $applicationConfig['modules']['global'];
    $modulesLocal = require $applicationConfig['modules']['local'];

    // Merge the configurations.
    $modules = array_merge($modulesGlobal, $modulesLocal);

    // Render the view with the data.
    $view = $app->view();
    $view->setTemplatesDirectory(APPLICATION_ROOT . 'module/' . $modules['Book']['path']['direction'] . $modules['Book']['path']['directory'] . 'view/');
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
