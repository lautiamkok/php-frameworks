<?php

// Note found page.
// @ref: http://help.slimframework.com/discussions/problems/4400-templatespath-doesnt-change
$app->notFound(function () use ($app) {
    $view = $app->view();
    $view->setTemplatesDirectory(APPLICATION_ROOT . 'module/core/PageNotFound/view/');
    $app->render('index.phtml');
});
