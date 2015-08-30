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

$applicationConfig = $app->config('application');

$globalConfig = require $applicationConfig['settings']['global'];
$localConfig = require $applicationConfig['settings']['local'];

$databaseConfig = array_merge($globalConfig['database'], $localConfig['database']);

var_dump($databaseConfig);

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

var_dump($article);

// Render the data.
$view = $app->view();
$view->setTemplatesDirectory(APPLICATION_ROOT . 'module/core/Article/view/');
$app->render('index.phtml', array(
    'id' => $article['articleId'],
    'title' => $article['title'],
    'content' => $article['content']
));
