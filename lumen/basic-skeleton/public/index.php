<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/

$app = require __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

// // @ref: https://laracasts.com/discuss/channels/lumen/always-404-sorry-the-page-you-are-looking-for-could-not-be-found
// // @ref: http://stackoverflow.com/questions/30891405/not-found-page-in-lumen-after-install
// $app->run($app['request']);

// Or:
// @ref: http://stackoverflow.com/questions/29728973/notfoundhttpexception-with-lumen/30254364#30254364
$request = Illuminate\Http\Request::capture();
$app->run($request);
