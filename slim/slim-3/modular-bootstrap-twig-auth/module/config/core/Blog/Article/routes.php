<?php
// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

// use Spectre\Blog\Article\Controller\BlogArticleController; // to be developed

// API group
$app->group('/blog', function () {
    // Get the login form.
    $this->get('/{url:[a-zA-Z0-9\-]+}', function (Request $request, Response $response, array $args) {
        // // Get the result via the controller.
        // $controller = new BlogArticleController($this); to be developed.
        // $controller($request, $response, $args);

        return $response->getBody()->write('Blog article page to be developed');
    });
});
