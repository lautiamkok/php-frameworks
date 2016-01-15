<?php
// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

use Spectre\Article\Controller\ArticleController;

// Get article by url.
$app->get('/{url:[a-zA-Z0-9\-]+}', function (Request $request, Response $response, array $args) {
    // Get the result by including the file.
    // return require_once APPLICATION_ROOT . 'module/result/core/Article/index.php';

    // Or:
    // Get the result via the controller.
    $controller = new ArticleController($this);
    $controller($request, $response, $args);
});
