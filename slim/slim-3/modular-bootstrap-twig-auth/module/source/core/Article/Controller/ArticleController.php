<?php
namespace Barium\Article\Controller;

use Barium\Controller\AbstractController;

class ArticleController extends AbstractController
{
    public function fetchRow($options = [])
    {
        // $this->ServiceStrategy->fetchRow($options);
        $this->MapperStrategy->populate($this->ModelStrategy, $options);
        return $this->ModelStrategy;
    }

    public function fetchTheme($options = [])
    {
        // $this->ServiceStrategy->fetchTheme($options);
        $this->MapperStrategy->populate($this->ModelStrategy, $options);
        return $this->ModelStrategy;
    }
}
