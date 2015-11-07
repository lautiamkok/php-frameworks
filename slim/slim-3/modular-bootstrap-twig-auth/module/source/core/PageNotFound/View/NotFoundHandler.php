<?php
/*
 * Handle the view of the page.
 *
 */
namespace Barium\PageNotFound\View;

use Slim\Handlers\NotFound;
use Twig_Environment;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

// Option 1:
class NotFoundHandler extends NotFound
{

    private $twig;
    private $settings;

    public function __construct(Twig_Environment $twig, $settings)
    {
        $this->twig = $twig;
        $this->settings = $settings;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        parent::__invoke($request, $response);

        // From that get the Twig Loader instance (file loader in this case).
        $loader = $this->twig->getLoader();

        // Load the template through the Twig service in the DIC.
        $template = $this->twig->loadTemplate('PageNotFound/index.html');

        // Render the template using a simple content variable.
        $response->write($template->render([]));

        return $response->withStatus(404);
    }
}

// // Option 2:
// namespace Barium\PageNotFound\View;

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
