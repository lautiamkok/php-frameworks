<?php
session_cache_limiter(false);
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\Slim();

// @ref: http://help.slimframework.com/discussions/questions/265-return-custom-error-code-and-error-message
$authAdmin = function () {

    $app = \Slim\Slim::getInstance();

    // Check for authenticated user in the session
    if (!isset($_SESSION['user'])) {
        $app->redirect('login');
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

// Access admin area.
$app->get('/admin', $authAdmin, function () use ($app) {
   echo "Hello Admin ";
})->name('admin');

// Get and post the login form.
$app->map('/login', function () use ($app) {

    // Test for Post & make a cheap security check, to get avoid from bots
    if ($app->request()->isPost() && sizeof($app->request()->post()) >= 2) {

        // Don't forget to set the correct attributes in your form (name="username" + name="password")
        $post = (object)$app->request()->post();

        // Validate the username and password against the row in the db.
        if(isset($post->username) && isset ($post->password) && ($post->username === 'demo' && $post->password === 'demo')) {
            $_SESSION['user'] = 'xxxx';
            $app->redirect('admin');
        } else {
            $app->redirect('login');
        }
    }

    // render login
    $app->render('login.twig');

})->via('GET','POST')->name('login');

$app->run();
