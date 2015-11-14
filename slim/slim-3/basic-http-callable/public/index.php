<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/HelloController.php';

$app = new \Slim\App();

// Routes:
$app->get('/hello/{name}', 'HelloController::hello');

$app->run();
