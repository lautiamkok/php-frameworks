<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = new \Slim\Slim();
$app->add(new \Foo\AllCapsMiddleware());
$app->get('/foo', function () use ($app) {
    echo "Hello";
});
$app->run();
