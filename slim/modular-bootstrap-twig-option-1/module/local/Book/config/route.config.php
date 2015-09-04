<?php

// Get book with ID
$app->get('/books/:id', function ($id) use ($app) {
    // Update book identified by $id.
    $allGetVars = $app->request->get();
    $title = $app->request->get('title');
    $content = $app->request->get('content');

    // Get the application configuration.
    $applicationConfig = $app->config('application');

    // Get the global & local modules configurations.
    $modulesGlobal = require $applicationConfig['modules']['global'];
    $modulesLocal = require $applicationConfig['modules']['local'];

    // Merge the configurations.
    $modules = array_merge($modulesGlobal, $modulesLocal);

    // Set the module template path to the existing.
    // The problem with this option is you cannot separate module template from the base's.
    // With Twig, the base template can be extended into the module's. Thus, you don't need
    // the Slim default if you use Twig.
    // $view = $app->view();
    // $view->setTemplatesDirectory(APPLICATION_ROOT . 'module/' . $modules['Book']['path']['direction'] . $modules['Book']['path']['directory'] . 'view/');

    // Get an instance of the Twig Environment.
    $twig = $app->view->getInstance();

    // From that get the Twig Loader instance (file loader in this case).
    $loader = $twig->getLoader();

    // Add the module template and additional paths to the existing.
    $loader->addPath(APPLICATION_ROOT . 'public/theme/default/');
    $loader->addPath(APPLICATION_ROOT . 'module/' . $modules['Book']['path']['direction'] . $modules['Book']['path']['directory'] . 'view/');

    // Render the view with the data.
    $app->render('index.twig', array(
        'base_url' => BASE_URL,
        'id' => $id,
        'title' => $title,
        'content' => $content
    ));

    // Or:
    // $loader = new Twig_Loader_Filesystem(array(
    //     APPLICATION_ROOT . 'public/template/default/',
    //     APPLICATION_ROOT . 'module/' . $modules['Book']['path']['direction'] . $modules['Book']['path']['directory'] . 'view/'
    // ));
    // $twig = new Twig_Environment($loader);

    // echo $twig->render('index.twig', array(
    //     'base_url' => APPLICATION_ROOT . 'public\\',
    //     'id' => $id,
    //     'title' => $title,
    //     'content' => $content
    // ));
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
    $app->render('index.twig', array(
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
