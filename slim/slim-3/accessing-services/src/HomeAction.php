<?php

class HomeAction
{
    public function __construct($books)
    {
        $this->books = $books;
    }

    public function dispatch($request, $response, $args)
    {
        $books = $this->books;
        // do something with $books and then return a response

        return $response->write('Hello World from HomeAction!');
    }
}
