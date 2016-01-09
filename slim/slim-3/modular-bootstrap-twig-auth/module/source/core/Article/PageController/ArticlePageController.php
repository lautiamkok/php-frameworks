<?php
namespace Barium\Article\PageController;

// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

// Page Controller.
use Barium\PageController\AbstractPageController;

// Adapter.
use Barium\Adapter\PdoAdapter;

// Mapper.
use Barium\Article\Mapper\ArticleMapper;

// Gateway.
use Barium\Article\Gateway\ArticleGateway;

// Controller.
use Barium\Article\Controller\ArticleController;

// Model.
use Barium\Article\Model\ArticleModel;

// Component.
use Barium\Article\Component\ArticleContentComponent;
use Barium\Article\Component\ArticleTemplateComponent;

// View.
use Barium\Article\View\ArticleView;

class ArticlePageController extends AbstractPageController
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

            // Initiate the triad.
            // It is important that the controller and the view
            // share the model.

            // Model.
            $ArticleModel = new ArticleModel();

            // Gateway & Mapper.
            $ArticleGateway = new ArticleGateway($PdoAdapter);
            $ArticleMapper = new ArticleMapper($ArticleGateway, $ArticleModel);

            // Components.
            $ArticleContentComponent = new ArticleContentComponent($PdoAdapter);
            $ArticleTemplateComponent = new ArticleTemplateComponent($PdoAdapter);

            // Inject components.
            $ArticleGateway->addComponent($ArticleContentComponent);
            $ArticleGateway->addComponent($ArticleTemplateComponent);

            // Controller.
            $ArticleController = new ArticleController($ArticleMapper);

            // Control the article.
            $ArticleController->getArticle([
                "url" => $args['url']
            ]);

            // Prepare view and pass the model into it.
            // No longer in use, replaced by Slim & Twig.
            // $ArticleView = new ArticleView($ArticleModel);
            // echo $ArticleView->render();

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
