<?php

// Note found page.
// @ref: http://help.slimframework.com/discussions/problems/4400-templatespath-doesnt-change
$app->notFound(function () use ($app) {
    $view = $app->view();
    $view->setTemplatesDirectory(APPLICATION_ROOT . 'public/theme/default/PageNotFound/');
    $app->render('index.html');
});
