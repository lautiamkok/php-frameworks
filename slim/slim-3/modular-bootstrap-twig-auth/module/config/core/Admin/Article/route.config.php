<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Barium\Admin\Middleware\AuthMiddleware;

// API group
$app->group('/api', function () {

    // Admin group
    $this->group('/admin', function () {
        // Get article with ID
        $this->get('/articles/{id}', function (Request $request, Response $response, array $args) {
            // Update book identified by $id.
            $id = $request->getAttribute('id');
            print_r($id);
        });

        // Update article with ID
        $this->put('/articles/{id}', function (Request $request, Response $response, array $args) {
            // Update book identified by $id.
            $id = $request->getAttribute('id');
            print_r($id);
        });

        // Get the login form.
        $this->get('/login', function (Request $request, Response $response, array $args) {
            // Get an instance of the Twig Environment.
            $twig = $this->view;

            // From that get the Twig Loader instance (file loader in this case).
            $loader = $twig->getLoader();

            // Add the module template and additional paths to the existing.
            $loader->addPath(APPLICATION_ROOT . 'public/theme/default/');
            $loader->addPath(APPLICATION_ROOT . 'public/theme/default/Login/');

            // Load the template through the Twig service in the DIC.
            $template = $twig->loadTemplate('index.twig');
            // or:
            // $template = $this->getContainer()->get('view')->loadTemplate('Login/index.twig');

            // Render the template using a simple content variable.
            return $response->write($template->render([]));
        });
    });

})->add(new AuthMiddleware());
// })->add(function ($request, $response, $next) {
//     $response->getBody()->write('It is now ');
//     $response = $next($request, $response);
//     $response->getBody()->write('. Enjoy!');

//     return $response;
// });
