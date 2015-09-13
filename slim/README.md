# Getting started: A skeleton application

1. Install Slim

    `composer require slim/slim`

## Ref:

    * http://www.slimframework.com/
    * http://docs.slimframework.com/

# HTTP Response VS Echo

The HTTP response returned to the client will have a body. The HTTP body is the actual content of the HTTP response delivered to the client. You can use the Slim application’s response object to set the HTTP response’s body:

    ```
    $app = new \Slim\Slim();

    // Overwrite response body
    $app->response->setBody('Foo');

    // Append response body
    $app->response->write('Bar');
    ```

Usually, you will never need to **manually** set the response body with the setBody() or write() methods; instead, the Slim app will do this for you. Whenever you echo() content inside a route's callback function, the echo()’d content is captured in an output buffer and appended to the response body before the HTTP response is returned to the client.

For instance, there is no differences between returning http response and echo output below,

    ```
    $app = new \Slim\Slim();

    $app->get('/hello/:name', function ($name) use ($app) {

        $response = $app->response;
        $response->setBody("Hello, " . $name);
        return $response;
    });
    ```

    VS,

    ```
    $app->get('/hello/:name', function ($name) {
        echo "Hello, " . $name;
    });
    ```

Both give you,

    > Hello, World

If you want to overwrite the output instead to appending to it you will have to use the $response object.

## Ref:

    * http://docs.slimframework.com/response/body/
    * http://stackoverflow.com/questions/32535374/slim-framework-differences-between-returning-http-response-and-echo-output

# A Slim3 Skeleton

1. Install

    `composer create-project -n -s dev akrabat/slim3-skeleton basic-skeleton`

2. Run it on built-in PHP web server

    `cd basic-skeleton`

    `php -S 0.0.0.0:8888 -t public public/index.php`

3. Browse to `http://localhost:8888`
