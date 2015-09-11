<?php

namespace Application;

use Zend\Diactoros\Response\JsonResponse;

class Ping
{
    public function __invoke($req, $res, $next)
    {
        return new JsonResponse(['ack' => time()]);
    }
}
