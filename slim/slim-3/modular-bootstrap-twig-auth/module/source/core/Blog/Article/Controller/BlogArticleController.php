<?php
namespace Spectre\Blog\Article\Controller;

// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

// Controller.
use Spectre\Controller\AbstractController;

// Service.
use Spectre\Blog\Article\Service\BlogArticleService;

// Adapter.
use Spectre\Adapter\PdoAdapter;

// Mapper.
use Spectre\Blog\Article\Mapper\BlogArticleMapper;

// Gateway.
use Spectre\Blog\Article\Gateway\BlogArticleGateway;

// Visitor.
use Spectre\Blog\Article\Visitor\Template\BlogArticleTemplateGateway;
use Spectre\Blog\Article\Visitor\Template\BlogArticleTemplateMapper;

use Spectre\Blog\Article\Visitor\Content\BlogArticleContentGateway;
use Spectre\Blog\Article\Visitor\Content\BlogArticleContentMapper;

class BlogArticleController extends AbstractController
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
        $BlogArticleGateway = new BlogArticleGateway($PdoAdapter);
        $BlogArticleMapper = new BlogArticleMapper($BlogArticleGateway);

        // Service.
        $BlogArticleService = new BlogArticleService($BlogArticleMapper);

        // Get the article object.
        $BlogArticleModel = $BlogArticleService->getArticle([
            "url" => $args['url']
        ]);

        // Visitors.
        $BlogArticleTemplateMapper = new BlogArticleTemplateMapper(new BlogArticleTemplateGateway($PdoAdapter));
        $BlogArticleContentMapper = new BlogArticleContentMapper(new BlogArticleContentGateway($PdoAdapter));

        // Inject Visitors.
        $BlogArticleModel->accept($BlogArticleTemplateMapper);
        $BlogArticleModel->accept($BlogArticleContentMapper);

        print_r($BlogArticleModel);

        // Get format in the query string.
        $allGetVars = $request->getQueryParams();
        $format = isset($allGetVars['format']) ? $allGetVars['format'] : null;

        // Encode the data to json - if the json is requested.
        if ($format === 'json') {
            $response->getBody()->write(json_encode($article));
            return $response->withHeader('Content-type', 'application/json');
        }

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
        return $response->write($template->render([
            'baseUrl' => BASE_URL,
            'articleId' => $BlogArticleModel->getArticleId(),
            'title' => $BlogArticleModel->getTitle(),
            'content' => $BlogArticleModel->getContent()
        ]));
    }
}
