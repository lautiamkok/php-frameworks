<?php

// Note found page.
// @ref: http://help.slimframework.com/discussions/problems/4400-templatespath-doesnt-change
$app->notFound(function () use ($app) {

    // Get the application configuration.
    $applicationConfig = $app->config('application');

    // Get the global & local modules configurations.
    $modulesGlobal = require $applicationConfig['modules']['global'];
    $modulesLocal = require $applicationConfig['modules']['local'];

    // Merge the configurations.
    $modules = array_merge($modulesGlobal, $modulesLocal);


    $view = $app->view();
    $view->setTemplatesDirectory(APPLICATION_ROOT . 'public/theme/' . $modules['PageNotFound']['directories']['theme'] . $modules['PageNotFound']['directories']['template']);
    $app->render('index.html');
});
