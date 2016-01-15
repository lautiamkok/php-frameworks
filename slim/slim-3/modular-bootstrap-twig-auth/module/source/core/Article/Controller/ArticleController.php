<?php
namespace Spectre\Article\Controller;

// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

// Controller.
use Spectre\Controller\AbstractController;

// Service.
use Spectre\Article\Service\ArticleService;

// Adapter.
use Spectre\Adapter\PdoAdapter;

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
       // Trigger exception in a "try" block
        try {
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
            $ArticleGateway = new ArticleGateway($PdoAdapter);
            $ArticleMapper = new ArticleMapper($ArticleGateway);

            // Service.
            $ArticleService = new ArticleService($ArticleMapper);

            // Get the article object.
            $ArticleModel = $ArticleService->getArticle([
                "url" => $args['url']
            ]);

            // Visitors.
            $ArticleTemplateMapper = new ArticleTemplateMapper(new ArticleTemplateGateway($PdoAdapter));
            $ArticleContentMapper = new ArticleContentMapper(new ArticleContentGateway($PdoAdapter));

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

            // // Or (option 1 in config):
            // // Render the view with the data.
            // return $this->view->render($response, 'index.twig', array(
            //     'baseUrl' => BASE_URL,
            //     'articleId' => $article['articleId'],
            //     'title' => $article['title'],
            //     'content' => $article['content']
            // ));

        } catch(\Exception $e) {
            echo 'Message: ' .$e->getMessage();
            // $container = $this;
            // return require_once APPLICATION_ROOT . 'module/result/core/PageNotFound/index.php';
        }
    }
}
