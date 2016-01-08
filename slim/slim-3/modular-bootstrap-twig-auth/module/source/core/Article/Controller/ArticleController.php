<?php
namespace Barium\Article\Controller;

use Barium\Controller\AbstractController;

class ArticleController extends AbstractController
{
    public function getArticle($options = [])
    {
        $this->MapperStrategy->getOne($options);
    }

    public function fetchTheme($options = [])
    {
        $this->MapperStrategy->getTheme($options);
    }
}
