<?php

// Get all articles.
$app->get('/articles', function () use ($app) {
    // Get the bootstrap.
    //require_once APPLICATION_ROOT . 'module/bootstrap/core/Article/index.php';
});

// Get article by url.
$app->get('/articles/:url', function ($url) use ($app) {
    // Get the bootstrap.
    require_once APPLICATION_ROOT . 'module/bootstrap/core/Article/index.php';
});
