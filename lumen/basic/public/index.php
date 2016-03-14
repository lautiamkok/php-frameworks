<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

// Basic Routing.
$app->get('/', function () {
    return 'Hello World';
});

$app->get('/lumen', function () use ($app) {
    return $app->welcome();
});

$app->post('foo/bar', function () {
    return 'Hello World';
});

$app->put('foo/bar', function () {
    //
});

$app->delete('foo/bar', function () {
    //
});

// Route Parameters.
$app->get('user/{id}', function ($id) {
    return 'User '.$id;
});

$app->get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    //
});

// // @ref: https://laracasts.com/discuss/channels/lumen/always-404-sorry-the-page-you-are-looking-for-could-not-be-found
// // @ref: http://stackoverflow.com/questions/30891405/not-found-page-in-lumen-after-install
// $app->run($app['request']);

// Or:
// @ref: http://stackoverflow.com/questions/29728973/notfoundhttpexception-with-lumen/30254364#30254364
$request = Illuminate\Http\Request::capture();
$app->run($request);
