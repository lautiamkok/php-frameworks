<?php
// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

// API group
$app->group('/blog', function () {
    // Get the login form.
    $this->get('/{url:[a-zA-Z0-9\-]+}', function (Request $request, Response $response, array $args) {
        // // Get an instance of the Twig Environment.
        // $twig = $this->view;

        // // From that get the Twig Loader instance (file loader in this case).
        // $loader = $twig->getLoader();

        // // Add the module template and additional paths to the existing.
        // $loader->addPath(APPLICATION_ROOT . 'public/theme/default/');
        // $loader->addPath(APPLICATION_ROOT . 'public/theme/default/Login/');

        // // Load the template through the Twig service in the DIC.
        // $template = $twig->loadTemplate('index.twig');
        // // or:
        // // $template = $this->getContainer()->get('view')->loadTemplate('Login/index.twig');

        // // Render the template using a simple content variable.
        // return $response->write($template->render([]));
        return $response->getBody()->write('Fallback Hello World!');
    });
});
