<?php
// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

// Get all articles.
$app->get('/articles', function (Request $request, Response $response, array $args) {
    $response->getBody()->write('Articles Home!');
    return $response;
});

// Get article by url.
$app->get('/articles/{url}', function (Request $request, Response $response, array $args) {
    // Get the result by including the file.
    // return require_once APPLICATION_ROOT . 'module/result/core/Article/index.php';

    // Or:
    // Get the result via the front controller.
    $controller = new \Barium\Article\FrontController\ArticleFrontController($this);
    $controller($request, $response, $args);
});
