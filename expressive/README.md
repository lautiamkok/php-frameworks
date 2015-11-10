# Getting started: Hello World!

1. Install Expressive and dependencies

    `composer require zendframework/zend-expressive aura/router zendframework/zend-servicemanager`

    or skeleton:

    `composer create-project zendframework/zend-expressive-skeleton expressive`

2. Create the hello world index at public/index.php

    ```
    // In index.php
    use Zend\Expressive\AppFactory;

    require 'vendor/autoload.php';

    $app = AppFactory::create();
    $app->route('/', function ($request, $response, $next) {
        $response->getBody()->write('Hello, world!');
        return $response;
    });
    $app->run();

    ```

3. Start a web server

    Change the path to public/,

    'cd public/'

    then,

    `php -S 0.0.0.0:8080 -t .`

4. Browse to localhost:8080, and you should see it running!

## Ref:

    * http://zend-expressive.readthedocs.org/en/stable/quick-start/
    * http://framework.zend.com/blog/announcing-expressive.html
    * http://zend-expressive.readthedocs.org/en/stable/usage-examples/
