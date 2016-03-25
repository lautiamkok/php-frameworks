<?php
namespace Spectre\ClientError\NotFound\Controller;

// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

// Controller.
use Spectre\Controller\AbstractController;

// Service.
use Spectre\ClientError\NotFound\Service\NotFoundService;

// Adapter.
use Spectre\Adapter\PdoAdapter;

// Mapper.
use Spectre\ClientError\NotFound\Mapper\NotFoundMapper;

// Gateway.
use Spectre\ClientError\NotFound\Gateway\NotFoundGateway;

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

        // Get an instance of the Twig Environment.
        $twig = $this->container->view;

        // From that get the Twig Loader instance (file loader in this case).
        $loader = $twig->getLoader();

        // Add the module template and additional paths to the existing.
        $loader->addPath(APPLICATION_ROOT . 'public/theme/default/');
        $loader->addPath(APPLICATION_ROOT . 'public/theme/default/Article/');

        // Load the template through the Twig service in the DIC.
        $template = $twig->loadTemplate('index.twig');

        // Render the template using a simple content variable.
        $response->write($template->render([
            'baseUrl' => BASE_URL,
            'articleId' => '',
            'title' => '404 Not Found',
            'content' => 'Not Found'
        ]));

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
