<?php
namespace Spectre\Article\Controller;

// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

// Database.
use Spectre\Database\DatabaseFactory;

// Controller.
use Spectre\Controller\AbstractController;

// Service.
use Spectre\Article\Service\ArticleService;

// Mapper.
use Spectre\Article\Mapper\ArticleMapper;

// Gateway.
use Spectre\Article\Gateway\ArticleGateway;

// Visitor.
use Spectre\Article\Visitor\Template\ArticleTemplateGateway;
use Spectre\Article\Visitor\Template\ArticleTemplateMapper;

use Spectre\Article\Visitor\Content\ArticleContentGateway;
use Spectre\Article\Visitor\Content\ArticleContentMapper;

class ArticleController extends AbstractController
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

        // Instance of Database.
        $DatabaseFactory = new DatabaseFactory($databaseConfig);
        $Database = $DatabaseFactory->getFactory($databaseConfig['driver']);

        // Make connection.
        $Database->connect();

        // Gateway & Mapper.
        $ArticleGateway = new ArticleGateway($Database);
        $ArticleMapper = new ArticleMapper($ArticleGateway);

        // Service.
        $ArticleService = new ArticleService($ArticleMapper);

        // Get the article object.
        $ArticleModel = $ArticleService->getArticle([
            "url" => $args['url']
        ]);

        // Visitors.
        $ArticleTemplateMapper = new ArticleTemplateMapper(new ArticleTemplateGateway($Database));
        $ArticleContentMapper = new ArticleContentMapper(new ArticleContentGateway($Database));

        // Inject Visitors.
        $ArticleModel->accept($ArticleTemplateMapper);
        $ArticleModel->accept($ArticleContentMapper);

        print_r($ArticleModel);

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
            'articleId' => $ArticleModel->getArticleId(),
            'title' => $ArticleModel->getTitle(),
            'content' => $ArticleModel->getContent()
        ]));
    }
}
