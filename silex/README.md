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
