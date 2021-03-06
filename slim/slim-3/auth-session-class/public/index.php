<?php

session_cache_limiter(false);
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;
use App\Middleware\AuthMiddleware;

$app = new \Slim\App();

// Get the Slim container.
$container = $app->getContainer();

// Register component on container
// Add a Twig service to the container.
$container['twig'] = function($container) {
    $loader = new Twig_Loader_Filesystem('template/');
    return new Twig_Environment($loader, array('cache'));
};

// Access home page.
$app->get('/', function (Request $request, Response $response, array $args) {

    $response->getBody()->write('Hello, World!');
    return $response->withHeader('Content-type', 'application/json');

});

// Access hello.
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {

    // fetch the id attribute to discover what was matched.
    $name = $request->getAttribute('name');

    $response->getBody()->write('Hello, ' . $name);
    return $response->withHeader('Content-type', 'application/json');

});

// Access admin area.
$app->get('/admin', function (Request $request, Response $response, array $args) {
   // echo "Hello Admin ";
    $response->getBody()->write('Hello, Admin');
    return $response->withHeader('Content-type', 'application/json');
})->add(new AuthMiddleware());

// Get the login form.
$app->get('/login', function (Request $request, Response $response, array $args) {

    // Load the template through the Twig service in the DIC.
    $template = $this->getContainer()->get('twig')->loadTemplate('login.twig');

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
            return $response->withRedirect('admin');
        } else {
            return $response->withRedirect('login');
        }

    }

});

$app->run();
