<?php
namespace Barium\Blog\Controller;

// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

// Controller.
use Barium\Controller\AbstractController;

// Service.
use Barium\Blog\Service\BlogService;

// Adapter.
use Barium\Adapter\PdoAdapter;

// Mapper.
use Barium\Blog\Mapper\BlogMapper;
use Barium\Blog\Mapper\BlogCollectionMapper;

// Gateway.
use Barium\Blog\Gateway\BlogGateway;
use Barium\Blog\Gateway\BlogCollectionGateway;

// Component.
use Barium\Article\Component\ArticleContentComponent;
use Barium\Article\Component\ArticleTemplateComponent;

class BlogController extends AbstractController
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
            $BlogGateway = new BlogGateway($PdoAdapter);
            $BlogMapper = new BlogMapper($BlogGateway);
            $BlogCollectionGateway = new BlogCollectionGateway($PdoAdapter);
            $BlogCollectionMapper = new BlogCollectionMapper($BlogCollectionGateway);

            // Components.
            $BlogContentComponent = new ArticleContentComponent($PdoAdapter);
            $BlogTemplateComponent = new ArticleTemplateComponent($PdoAdapter);

            // Inject components.
            $BlogGateway->addComponent($BlogContentComponent);
            $BlogGateway->addComponent($BlogTemplateComponent);

            // Service.
            $BlogService = new BlogService($BlogMapper, $BlogCollectionMapper);

            // Get the blog.
            $BlogModel = $BlogService->getBlog([
                "url" => 'blog',
                "articles" => [
                    "type" => "post",
                    "start_row" => 0,
                    "limit" => 6
                ]
            ]);

            print_r($BlogModel);

            // $model->setArticles(
            //     $BlogArticleMapper->getBlogArticle($params)
            // );

            // print_r($model);

            // // Get format in the query string.
            // $allGetVars = $request->getQueryParams();
            // $format = isset($allGetVars['format']) ? $allGetVars['format'] : null;

            // // Encode the data to json - if the json is requested.
            // if ($format === 'json') {
            //     return $response->getBody()->write(json_encode($Blog));
            // }

            // // Get an instance of the Twig Environment.
            // $twig = $this->container->view;

            // // From that get the Twig Loader instance (file loader in this case).
            // $loader = $twig->getLoader();

            // // Add the module template and additional paths to the existing.
            // $loader->addPath(APPLICATION_ROOT . 'public/theme/default/');
            // $loader->addPath(APPLICATION_ROOT . 'public/theme/default/Blog/');

            // // Load the template through the Twig service in the DIC.
            // $template = $twig->loadTemplate('index.twig');

            // // Render the template using a simple content variable.
            // return $response->write($template->render([
            //     'baseUrl' => BASE_URL,
            //     'blogId' => $BlogModel->getBlogId(),
            //     'title' => $BlogModel->getTitle(),
            //     'content' => $BlogModel->getContent()
            // ]));

        } catch(\Exception $e) {
            echo 'Message: ' .$e->getMessage();
            // $container = $this;
            // return require_once APPLICATION_ROOT . 'module/result/core/PageNotFound/index.php';
        }
    }
}
