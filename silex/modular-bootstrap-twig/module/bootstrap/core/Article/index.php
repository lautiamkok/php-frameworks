<?php

// Symfony's.
use Symfony\Component\HttpFoundation\Response;

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

// Get the application settings.
$settings = $app['settings']['settings'];

// Get the global & local database configurations.
$databaseGlobal = require $settings['database']['global'];
$databaseLocal = require $settings['database']['local'];

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
// echo $ArticleView->render();
// return new Response($ArticleView->render(), 200);

// Get the array format of the data.
$article = $ArticleModel->toArray();

// // Get format in the query string.
// $allGetVars = $request->getQueryParams();
// $format = isset($allGetVars['format']) ? $allGetVars['format'] : null;

// // Encode the data to json - if the json is requested.
// if ($format === 'json') {
//     $response->getBody()->write(json_encode($article));
//     return $response->withHeader('Content-type', 'application/json');
// }

// Silex internal Twig.
$twig = $app['twig'];

// From that get the Twig Loader instance (file loader in this case).
$loader = $twig->getLoader();

// Add the module template and additional paths to the existing.
$loader->addPath(APPLICATION_ROOT . 'public/theme/default/');
$loader->addPath(APPLICATION_ROOT . 'public/theme/default/Article/');

// Render the view with the data.
return new Response($app['twig']->render('index.twig', array(
    'baseUrl' => BASE_URL,
    'articleId' => $article['articleId'],
    'title' => $article['title'],
    'content' => $article['content']
)), 200);

// // Or:
// // Call Twig manually.
// $loader = new Twig_Loader_Filesystem(APPLICATION_ROOT . 'public/theme/default/');

// // Add the module template and additional paths to the existing.
// $loader->addPath(APPLICATION_ROOT . 'public/theme/default/');
// $loader->addPath(APPLICATION_ROOT . 'public/theme/default/Article/');

// $twig = new Twig_Environment($loader, array(
//     'cache' => 'cache/twig/',
// ));

// return new Response($twig->render('index.twig', array(
//     'baseUrl' => BASE_URL,
//     'articleId' => $article['articleId'],
//     'title' => $article['title'],
//     'content' => $article['content']
// )), 200);
