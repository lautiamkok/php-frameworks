<?php

use Slim\Http\Request;
use Slim\Http\Response;

class HelloController
{
    public static function hello(Request $request, Response $response, array $args)
    {
        // fetch the id attribute to discover what was matched.
        $name = $request->getAttribute('name');

        $response->getBody()->write('Hello, ' . $name);
        return $response->withHeader('Content-type', 'application/json');
    }
}


