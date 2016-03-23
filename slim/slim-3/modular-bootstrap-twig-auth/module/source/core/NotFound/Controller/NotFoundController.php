<?php
namespace Spectre\NotFound\Controller;

// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

// Controller.
use Spectre\Controller\AbstractController;

// Service.
use Spectre\NotFound\Service\NotFoundService;

// Adapter.
use Spectre\Adapter\PdoAdapter;

// Mapper.
use Spectre\NotFound\Mapper\NotFoundMapper;

// Gateway.
use Spectre\NotFound\Gateway\NotFoundGateway;

// Option 1:
class NotFoundController
{
    /**
     * [$container description]
     * @var [type]
     */
    private $container;

    /**
     * [__construct description]
     * @param [type] $container [description]
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * [__invoke description]
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @return [type]             [description]
     */
    public function __invoke(Request $request, Response $response)
    {
        // Get the core & local database configurations.
        $databaseCore = require $this->container->settings['database']['core'];
        $databaseLocal = require $this->container->settings['database']['local'];

        // Merge the configurations.
        $databaseConfig = array_merge($databaseCore, $databaseLocal);

        // Instance of PdoAdapter.
        $PdoAdapter = new PdoAdapter($databaseConfig['dsn'], $databaseConfig['username'], $databaseConfig['password']);

        // Make connection.
        $PdoAdapter->connect();

        // Gateway & Mapper.
        $NotFoundGateway = new NotFoundGateway($PdoAdapter);
        $NotFoundMapper = new NotFoundMapper($NotFoundGateway);

        // Service.
        $NotFoundService = new NotFoundService($NotFoundMapper);

        // Get the article object.
        $NotFoundModel = $NotFoundService->getNotFound([
            "url" => '404 not found'
        ]);

        print_r($NotFoundModel);

        $container = $this->container;
        $response->getBody()->write('Not found!');
        return $response->withStatus(404);
    }
}

// // Option 2:
// namespace Spectre\PageNotFound;

// use Slim\Handlers\NotFound;
// use Twig_Environment;
// use Psr\Http\Message\ServerRequestInterface;
// use Psr\Http\Message\ResponseInterface;

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

// // Option 3:
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
