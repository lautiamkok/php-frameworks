<?php
namespace Spectre\Blog\Controller;

// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

// Controller.
use Spectre\Controller\AbstractController;

// Service.
use Spectre\Blog\Service\BlogService;

// Adapter.
use Spectre\Adapter\PdoAdapter;

// Mapper.
use Spectre\Blog\Mapper\BlogMapper;
use Spectre\Blog\Collection\Mapper\BlogCollectionMapper;

// Gateway.
use Spectre\Blog\Gateway\BlogGateway;
use Spectre\Blog\Collection\Gateway\BlogCollectionGateway;

// Visitor.
use Spectre\Blog\Collection\Article\Visitor\Content\BlogCollectionArticleContentGateway;
use Spectre\Blog\Collection\Article\Visitor\Content\BlogCollectionArticleContentMapper;

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

        // Service.
        $BlogService = new BlogService($BlogMapper, $BlogCollectionMapper);

        // Visitors/ Flyweights.
        $BlogCollectionArticleContentMapper = new BlogCollectionArticleContentMapper(new BlogCollectionArticleContentGateway($PdoAdapter));

        // Inject the visitors/ flyweights.
        $BlogCollectionMapper->addFlyweight($BlogCollectionArticleContentMapper);

        // Get the blog.
        $BlogModel = $BlogService->getBlog([
            "url" => 'blog',
            "collection" => [
                "type" => "post",
                "start_row" => 0,
                "limit" => 6
            ]
        ]);

        print_r($BlogModel);

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
    }
}
