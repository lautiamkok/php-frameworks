<?php

// Example 1:
// require_once __DIR__ . '/../vendor/autoload.php';

// $app = new \Slim\Slim();

// // Route middleware for simple API authentication.
// // @ref: http://www.slideshare.net/vvaswani/creating-rest-applications-with-the-slim-microframework
// function authenticate(\Slim\Route $route) {
//     $app = \Slim\Slim::getInstance();
//     $uid = $app->getEncryptedCookie('uid');
//     $key = $app->getEncryptedCookie('key');
//     if (validateUserKey($uid, $key) === false) {
//         $app->halt(401);
//     }
// }

// // Routes:
// $app->get('/', function () {
//     echo "Hello World ";
// });

// // Add API authentication for GET requests
// $app->get('/admin', 'authenticate', function () {
//     echo "Hello Admin ";
// });

// $app->run();

// Example 2:
require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\Slim();

// @ref: http://help.slimframework.com/discussions/problems/6-simple-user-login
$authAdmin = function  ( $role = 'member') {

    return function () use ( $role ) {

        $app = \Slim\Slim::getInstance();

        $app->request->headers->set('X-User', 'xxxx');

        // Check for password in the cookie
        if ($app->getEncryptedCookie('my_cookie', false) != 'demo') {
            $app->redirect('login');
        }
    };
};

// Config.
// @ ref: http://docs.slimframework.com/configuration/settings/
$app->config(array(
    'templates.path' => 'template/',
));

// Routes:
$app->get('/', function () {
    echo "Hello World ";
});

$app->get('/admin', $authAdmin('admin'), function () use ($app) {
    // Get request headers.
    $headers = $app->request->headers;
    var_dump($headers);
    echo "Hello Admin ";
})->name('admin');

$app->map('/login', function () use ($app) {

    // Test for Post & make a cheap security check, to get avoid from bots
    if ($app->request()->isPost() && sizeof($app->request()->post()) >= 2) {

        // Don't forget to set the correct attributes in your form (name="user" + name="password")
        $post = (object)$app->request()->post();

        if(isset($post->user) && isset ($post->password)) {
            $app->setEncryptedCookie('my_cookie', $post->password);
            $app->redirect('admin');
        } else {
            $app->redirect('login');
        }
    }

    // render login
    $app->render('login.twig');

})->via('GET','POST')->name('login');

$app->run();
