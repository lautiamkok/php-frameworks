<?php
/*
 * Handle the view of the page.
 *
 */
namespace Barium\PageNotFound\View;

use Slim\Handlers\NotFound;
use Slim\Views\Twig;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class NotFoundHandler extends NotFound
{

    private $view;
    private $settings;

    public function __construct(Twig $view, $settings)
    {
        $this->view = $view;
        $this->settings = $settings;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        parent::__invoke($request, $response);

        $this->view->render($response, 'PageNotFound/index.html');

        return $response->withStatus(404);
    }
}
