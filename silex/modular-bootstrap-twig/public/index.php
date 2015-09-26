<?php

// Import.
use Silex\Application as Silex;
use Silex\Provider\TwigServiceProvider;
use Barium\RouteFetcher;

// Include application bootstrap.
chdir(dirname(__DIR__));
require 'bootstrap.php';

// Set website public documentroot.
define ('WEBSITE_DOCROOT', str_replace('\\', '/', dirname(__FILE__)) .'/');

// Get the application settings file.
$settings = require 'config/application.config.php';

// Get an instance of Silex.
$app = new Silex();

// Inject settings.
$app['settings'] = require 'config/application.config.php';

// Dependencies.
$app->register(new TwigServiceProvider(), array(
    'twig.path' => APPLICATION_ROOT . 'public/theme/default/',
    'twig.loader' => new Twig_Loader_Filesystem(APPLICATION_ROOT . 'public/theme/default/'),
));

// Get an instance of RouteFetcher.
$RouteFetcher = new RouteFetcher($app);

// Fetch the routes.
$RouteFetcher->fetch();

// When developing a website, you might want to turn on the debug mode to ease debugging.
$app['debug'] = true;

$app->run();
