<?php
namespace Barium\Article\Controller;

use Barium\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * '[getArticle description]'
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getArticle($options = [])
    {
        $this->MapperStrategy->getOne($options);
    }

    /**
     * [fetchTheme description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function fetchTheme($options = [])
    {
        $this->MapperStrategy->getTheme($options);
    }
}
