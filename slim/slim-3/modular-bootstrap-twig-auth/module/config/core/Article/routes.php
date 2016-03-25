<?php
// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

use Spectre\Article\Controller\ArticleController;
use Spectre\ClientError\NotFound\Controller\NotFoundController;

// Get article by url.
$app->get('/{url:[a-zA-Z0-9\-]+}', function (Request $request, Response $response, array $args) {
    // Trigger exception in a "try" block
    try {
        // Get the result via the controller.
        // Don't forget to return the controller.
        $ArticleController = new ArticleController($this);
        return $ArticleController($request, $response, $args);
    } catch(\Exception $e) {
        // Return 404 not found page.
        $NotFoundController = new NotFoundController($this);
        return $NotFoundController($request, $response);
    }
});
