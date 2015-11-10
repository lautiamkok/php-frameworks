<?php

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = include 'config/services.php';
$app = $container->get('Zend\Expressive\Application');
$app->run();
