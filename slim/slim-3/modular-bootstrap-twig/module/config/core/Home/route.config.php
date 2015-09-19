<?php

// Hope page.
$app->get('/', function () use ($app) {

    // Get the application configuration.
    $applicationConfig = $app->config('application');

    // Check if the home page bootstrap file is provided.
    if ($applicationConfig['home_page']['bootstrap']) {
        require_once APPLICATION_ROOT . 'module/bootstrap/' . $applicationConfig['home_page']['bootstrap'];
    } else {
        echo "Hello World!";
    }
});
