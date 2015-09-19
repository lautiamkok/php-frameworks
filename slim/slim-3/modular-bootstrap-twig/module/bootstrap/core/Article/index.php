<?php

// Adapter.
use Barium\Adapter\PdoAdapter;

// Mapper.
use Barium\Article\Mapper\ArticleMapper;

// Service.
use Barium\Article\Service\ArticleService;

// Controller.
use Barium\Article\Controller\ArticleController;

// Model.
use Barium\Article\Model\ArticleModel;

// Component.
use Barium\Article\Component\ArticleContentComponent;
use Barium\Article\Component\ArticleTemplateComponent;

// View.
use Barium\Article\View\ArticleView;

// Get the application configuration.
$applicationConfig = $app->config('application');

// Get the global & local database configurations.
$databaseGlobal = require $applicationConfig['database']['global'];
$databaseLocal = require $applicationConfig['database']['local'];

// Merge the configurations.
$databaseConfig = array_merge($databaseGlobal, $databaseLocal);

// Instance of PdoAdapter.
$PdoAdapter = new PdoAdapter($databaseConfig['dsn'], $databaseConfig['username'], $databaseConfig['password']);

// Initiate the triad.
// It is important that the controller and the view
// share the model.

// Article.
$ArticleService = new ArticleService();
$ArticleController = new ArticleController();

// Make connection.
$PdoAdapter->connect();

// Prepare Article model.
$ArticleModel = new ArticleModel();
$ArticleMapper = new ArticleMapper($PdoAdapter);

// Prepare components.
$ArticleContentComponent = new ArticleContentComponent($PdoAdapter);
$ArticleTemplateComponent = new ArticleTemplateComponent($PdoAdapter);

// Inject components.
$ArticleMapper->addComponent($ArticleContentComponent);
$ArticleMapper->addComponent($ArticleTemplateComponent);

// Controll the article.
$ArticleService->setMapper($ArticleMapper)->setModel($ArticleModel);
$ArticleController->setService($ArticleService)->fetchRow([
    "url"   =>  $url
]);

// Prepare view and pass the model into it.
$ArticleView = new ArticleView($ArticleModel);
//echo $ArticleView->render();

// Get the array format of the data.
$article = $ArticleModel->toArray();

// Get format in the query string.
$format = $app->request()->get('format');

// Encode the data to json - if the json is requested.
if ($format === 'json') {
    $app->response->headers->set('Content-Type', 'application/json');
    return $app->response->body(json_encode($article));
}

// Render the data.
// $view = $app->view();
// $view->setTemplatesDirectory(APPLICATION_ROOT . 'module/core/Article/view/');
// $app->render('index.phtml', array(
//     'id' => $article['articleId'],
//     'title' => $article['title'],
//     'content' => $article['content']
// ));

// Get an instance of the Twig Environment.
$twig = $app->view->getInstance();

// From that get the Twig Loader instance (file loader in this case).
$loader = $twig->getLoader();

// Add the module template and additional paths to the existing.
$loader->addPath(APPLICATION_ROOT . 'public/theme/default/');
$loader->addPath(APPLICATION_ROOT . 'public/theme/default/Article/');

// Render the view with the data.
$app->render('index.twig', array(
    'baseUrl' => BASE_URL,
    'articleId' => $article['articleId'],
    'title' => $article['title'],
    'content' => $article['content']
));
