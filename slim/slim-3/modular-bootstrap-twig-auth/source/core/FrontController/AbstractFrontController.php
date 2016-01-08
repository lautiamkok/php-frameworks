<?php
// Abstract Front Controller.
namespace Barium\FrontController;

// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

// Interop Container standard.
use Interop\Container\ContainerInterface;

abstract class AbstractFrontController
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    abstract public function __invoke(Request $request, Response $response, array $args);
}
