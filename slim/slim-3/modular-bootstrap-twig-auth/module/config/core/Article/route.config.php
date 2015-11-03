<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Get all articles.
$app->get('/articles', function (Request $request, Response $response, array $args) {
    // Get the bootstrap.
    //require_once APPLICATION_ROOT . 'module/bootstrap/core/Article/index.php';
});

// Get article by url.
$app->get('/articles/{url}', function (Request $request, Response $response, array $args) {
    // Get the bootstrap.
    return require_once APPLICATION_ROOT . 'module/bootstrap/core/Article/index.php';
});
