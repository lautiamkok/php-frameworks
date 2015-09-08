<?php

// Turn on debug.
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Include Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';

// Set scheme.
$scheme = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';

// Live server.
//define('BASE_URL', $scheme . $_SERVER['SERVER_NAME'].'/');

// Developer server.
define('BASE_URL', $scheme . 'localhost/php-frameworks/slim/modular-bootstrap-twig-option-2/public/');

// Set application root - which is outside the public directory.
define('APPLICATION_ROOT', str_replace('\\', '/', dirname(__FILE__)) .'/');
