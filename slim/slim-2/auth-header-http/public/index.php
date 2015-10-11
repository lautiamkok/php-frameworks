<?php

// @ ref: http://www.9bitstudios.com/2013/06/basic-http-authentication-with-the-slim-php-framework-rest-api/
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/HttpBasicAuth.php';

use Slim\Slim;

$app = new Slim();

$app->add(new \HttpBasicAuth());

$app->get('/', function () use ($app) {

    // $request = $app->request();
    // $username  = $request->headers('PHP_AUTH_USER');
    // $password = $request->headers('PHP_AUTH_PW');

    // // Get request headers.
    // $headers = $app->request->headers;
    // var_dump($headers);

    // var_dump($username);
    // var_dump($password);

    echo "Hello Admin";
});

$app->run();
