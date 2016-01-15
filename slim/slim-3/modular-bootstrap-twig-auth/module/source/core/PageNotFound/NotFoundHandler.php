<?php
/*
 * Handle the view of the page.
 *
 */
namespace Spectre\PageNotFound;

use Slim\Handlers\NotFound;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

// Option 1:
class NotFoundHandler extends NotFound
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        parent::__invoke($request, $response);
        $container = $this->container;
        return require_once APPLICATION_ROOT . 'module/result/core/PageNotFound/index.php';
    }
}
// namespace Spectre\PageNotFound;

// use Slim\Handlers\NotFound;
// use Twig_Environment;
// use Psr\Http\Message\ServerRequestInterface;
// use Psr\Http\Message\ResponseInterface;

// // Option 1:
// class NotFoundHandler extends NotFound
// {
//     private $container;

//     public function __construct($container)
//     {
//         $this->container = $container;
//     }

//     public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
//     {
//         parent::__invoke($request, $response);

//         return require_once APPLICATION_ROOT . 'module/result/core/PageNotFound/index.php';
//     }
// }

// // Option 2:
// namespace Spectre\PageNotFound\View;

// use Slim\Handlers\NotFound;
// use Slim\Views\Twig;
// use Psr\Http\Message\ServerRequestInterface;
// use Psr\Http\Message\ResponseInterface;
// class NotFoundHandler extends NotFound
// {

//     private $view;
//     private $settings;

//     public function __construct(Twig $view, $settings)
//     {
//         $this->view = $view;
//         $this->settings = $settings;
//     }

//     public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
//     {
//         parent::__invoke($request, $response);

//         $this->view->render($response, 'PageNotFound/index.html');

//         return $response->withStatus(404);
//     }
// }
