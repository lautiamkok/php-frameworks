<?php
namespace YourCustomNamespace\Home\PageController;

// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

// Page Controller.
use Barium\PageController\AbstractPageController;

class HomePageController extends AbstractPageController
{
    /**
     * [__invoke description]
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @param  array    $args     [description]
     * @return [type]             [description]
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
       // Trigger exception in a "try" block
        try {
            return $response->getBody()->write('Custom Hello World!');
        } catch(\Exception $e) {
            //
        }
    }
}
