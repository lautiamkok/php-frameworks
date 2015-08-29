<?php

// Adapter.
use Barium\Adapter\PdoAdapter;

// Mapper.
use Barium\Article\Mapper\ArticleMapper;

// Model.
use Barium\Article\Model\ArticleModel;

$applicationConfig = $app->config('application');

$databaseGlobalConfig = require $applicationConfig['database']['global'];
$databaseLocalConfig = require $applicationConfig['database']['local'];

$databaseConfig = array_merge($databaseGlobalConfig, $databaseLocalConfig);

var_dump($databaseConfig);

// Instance of PdoAdapter.
$PdoAdapter = new PdoAdapter($databaseConfig['dsn'], $databaseConfig['username'], $databaseConfig['password']);

// Make connection.
$PdoAdapter->connect();

// Prepare Article model.
$ArticleModel = new ArticleModel();
$ArticleMapper = new ArticleMapper($PdoAdapter);

var_dump($ArticleMapper);
