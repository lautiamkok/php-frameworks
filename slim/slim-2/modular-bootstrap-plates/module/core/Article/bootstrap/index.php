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

// Template.
use League\Plates\Engine as Plates;

// Get the application configuration.
$applicationConfig = $app->config('application');

// Get the global & local database configurations.
$databaseGlobal = require $applicationConfig['database']['global'];
$databaseLocal = require $applicationConfig['database']['local'];

// Merge the configurations.
$databaseConfig = array_merge($databaseGlobal, $databaseLocal);

// Instance of PdoAdapter.
$PdoAdapter = new PdoAdapter($databaseConfig['dsn'], $databaseConfig['username'], $databaseConfig['password']);

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

// Inject components.
$ArticleMapper->addComponent($ArticleContentComponent);

// Controll the article.
$ArticleService->setMapper($ArticleMapper)->setModel($ArticleModel);
$ArticleController->setService($ArticleService)->fetchRow([
    "url"   =>  $url
]);

// Get the array format of the data.
$article = $ArticleModel->toArray();

// Create new Plates instance.
$templates = new Plates(APPLICATION_ROOT . 'module/core/Article/view/');

// Add folders.
$templates->addFolder('theme-default', APPLICATION_ROOT . 'public/theme/default/');

// Sets the default file extension to ".phtml" after engine instantiation.
//$templates->setFileExtension('phtml');

// Disable automatic file extensions
$templates->setFileExtension(null);

// Render a template
echo $templates->render('index.phtml', [
    'base_url' => BASE_URL,
    'articleId' => $article['articleId'],
    'title' => $article['title'],
    'content' => $article['content']
]);
