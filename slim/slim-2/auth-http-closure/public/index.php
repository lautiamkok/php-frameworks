<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\Slim();

// To test:
// 1. use jquery ajax to set and send the http headers.
// 2. use Chrome postman to set and send the http headers.
// 3. use cURL to set and send the http headers.
// @ref: https://www.youtube.com/watch?v=HGGtLoEpqm4
$authAdmin = function() {

    $app = \Slim\Slim::getInstance();
    $request = $app->request;
    $httpUser = $request->headers->get('x-user');
    $httpPass = $request->headers->get('x-pass');

    // Validate the user and password against the row in the db.
    $isValid = ($httpUser === 'demo' && $httpPass === 'demo') ? true : false;
    try {
        if ($isValid === false) {
            throw new Exception("Invalid user and password");
        }
    } catch (Exception $e) {
        $app->status(401);
        echo json_encode(array(
            'status' => 401,
            'message' => $e->getMessage()
        ));
        $app->stop();
    }
};

// Config.
$app->config(array(
    'templates.path' => 'template/',
));

// Home.
$app->get('/', function () {
    echo "Hello World ";
});

// Admin.
$app->get('/admin', $authAdmin, function () use ($app) {
   echo "Hello Admin ";
})->name('admin');

// Get login form.
$app->get('/login', function () use ($app) {
    $app->render('login.twig');
});

// Post login form.
$app->post('/login', function () use ($app) {

    // Test for Post & make a cheap security check, to get avoid from bots
    if ($app->request()->isPost() && sizeof($app->request()->post()) >= 2) {

        // Don't forget to set the correct attributes in your form (name="username" + name="password")
        $post = (object)$app->request()->post();

        // Validate the username and password against the row in the db.
        if(isset($post->username) && isset ($post->password) && ($post->username === 'demo' && $post->password === 'demo')) {

            // Return the result for jQuery to set the http headers.
            echo json_encode(array(
                'x-user' => $post->username,
                'x-pass' => $post->password
            ));
        } else {
            $app->redirect('login');
        }
    }
});

$app->run();
