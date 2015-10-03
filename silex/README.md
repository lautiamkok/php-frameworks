# Getting started: Hello World!

1. Install Silex (put this in your composer.json)

    ```
    {
        "require": {
            "silex/silex": "~1.3"
        }
    }
    ```

2. Create the hello world index at public/index.php

    ```
    require_once __DIR__.'/../vendor/autoload.php';

    $app = new Silex\Application();

    $app->get('/hello/{name}', function($name) use($app) {
        return 'Hello '.$app->escape($name);
    });

    $app->run();

    ```

## Ref:

    * http://silex.sensiolabs.org/download

# PSR-7

1. Install zend diactoros and symfony bridge

    `composer require zendframework/zend-diactoros`
    `composer symfony/psr-http-message-bridge`

## Ref:

    * http://symfony.com/doc/current/cookbook/psr7.html
    * http://symfony.com/blog/psr-7-support-in-symfony-is-here
    * http://zend-diactoros.readthedocs.org/en/stable/
