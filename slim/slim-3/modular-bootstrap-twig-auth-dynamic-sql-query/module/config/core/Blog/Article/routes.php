<?php
// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

use Spectre\Blog\Article\Controller\BlogArticleController;
use Spectre\ClientError\NotFound\Controller\NotFoundController;

// API group
$app->group('/blog', function () {
    // Get the login form.
    $this->get('/{url:[a-zA-Z0-9\-]+}', function (Request $request, Response $response, array $args) {
        // Trigger exception in a "try" block
        try {
            // Get the result via the controller.
            // Don't forget to return the controller.
            $BlogArticleController = new BlogArticleController($this);
            return $BlogArticleController($request, $response, $args);
        } catch(\Exception $e) {
            // Return 404 not found page.
            $NotFoundController = new NotFoundController($this);
            return $NotFoundController($request, $response);
        }
    });
});
