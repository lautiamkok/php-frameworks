<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/AdminAuthMiddleware.php';

$app = new \Slim\Slim();

$app->add(new \Foo\AdminAuthMiddleware());

// Config.
// @ ref: http://docs.slimframework.com/configuration/settings/
$app->config(array(
    'templates.path' => 'template/',
));

// Routes:
$app->get('/', function () {
    echo "Hello World ";
});

$app->get('/admin', function () use ($app) {
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
