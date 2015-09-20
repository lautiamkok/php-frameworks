<?php

// Get all articles.
$app->get('/articles', function ($request, $response, $args) {
    // Get the bootstrap.
    //require_once APPLICATION_ROOT . 'module/bootstrap/core/Article/index.php';
});

// Get article by url.
$app->get('/articles/{url}', function ($request, $response, $args) {
    // Get the bootstrap.
    return require_once APPLICATION_ROOT . 'module/bootstrap/core/Article/index.php';
});
