<?php

require_once __DIR__ . '/../vendor/autoload.php';

// @ref: http://www.slimframework.com/docs/features/templates.html
// Create container
$container = new \Slim\Container;

// Register component on container
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('template/', [
        //'cache' => 'path/to/cache'
    ]);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

//Override the default Not Found Handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('Page not found');
    };
};

$app = new \Slim\App($container);

// Routes:
$app->get('/hello/{name}', function ($request, $response, $args) {

    // fetch the id attribute to discover what was matched.
    $name = $request->getAttribute('name');

    return $this->view->render($response, 'profile.twig', [
        'name' => $args['name']
    ]);

});

$app->run();
