<?php

namespace Application;

class HelloWorld
{
    public function __invoke($req, $res, $next)
    {
        $res->write('Hello, world!');
        return $res;
    }
}
