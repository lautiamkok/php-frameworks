<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Get the login form.
$app->get('/login', function (Request $request, Response $response, array $args) {
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

// Post the login form.
$app->post('/login', function (Request $request, Response $response, array $args) {

    // Get all post parameters:
    $allPostPutVars = $request->getParsedBody();

    //Single POST/PUT parameter
    // $postParam = $allPostPutVars['postParam'];

    // Test for Post & make a cheap security check, to get avoid from bots
    if (sizeof($allPostPutVars) >= 2) {

        // Don't forget to set the correct attributes in your form (name="username" + name="password")
        $post = (object)$allPostPutVars;

        // Validate the username and password against the row in the db.
        if(isset($post->username) && isset ($post->password) && ($post->username === 'demo' && $post->password === 'demo')) {
            $_SESSION['user'] = 'xxxx';
            return $response->withRedirect('api/admin');
        } else {
            return $response->withRedirect('login');
        }

    }

});
