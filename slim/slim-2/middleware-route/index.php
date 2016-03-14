<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = new \Slim\Slim();

$aBitOfInfo = function (\Slim\Route $route) {
    echo "Current route is " . $route->getName();
};

$app->get('/foo', $aBitOfInfo, function () {
    echo "foooo";
});

$app->run();
