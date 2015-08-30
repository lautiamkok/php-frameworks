<?php 
namespace Barium\Article\Controller;

use Barium\Controller\AbstractController;

class ArticleController extends AbstractController
{
    public function fetchRow($options = [])
    {
        $this->ServiceStrategy->fetchRow($options);
    }
    
    public function fetchTheme($options = [])
    {
        $this->ServiceStrategy->fetchTheme($options);
    }
}