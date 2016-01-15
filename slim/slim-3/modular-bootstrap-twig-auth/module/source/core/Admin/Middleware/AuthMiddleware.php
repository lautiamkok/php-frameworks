<?php
namespace Spectre\Admin\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class AuthMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, Response $response, $next)
    {
        // Check for authenticated user in the session
        if (!isset($_SESSION['user'])) {
            // In Slim 3 you have to use the Response object for redirects.
            // @ ref: https://help.slimframework.com/discussions/questions/7639-slim3-how-to-redirect-to-route
            return $response->withRedirect(BASE_URL . 'admin/login');
        }

        $response->getBody()->write('BEFORE');
        $response = $next($request, $response);
        $response->getBody()->write('AFTER');

        return $response;
    }
}
