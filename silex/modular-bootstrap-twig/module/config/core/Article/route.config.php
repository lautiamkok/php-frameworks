<?php

use Symfony\Component\HttpFoundation\Request;

// Get all articles.
$app->get('/articles', function (Request $request) {
    // Get the bootstrap.
    //require_once APPLICATION_ROOT . 'module/bootstrap/core/Article/index.php';
});

// Get article by url.
$app->get('/articles/{url}', function ($url, Request $request) use ($app) {
    // Get the bootstrap.
    return require_once APPLICATION_ROOT . 'module/bootstrap/core/Article/index.php';
});
