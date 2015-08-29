<?php
/*
 * Handle the view of the page.
 *
*/ 
namespace Barium\Article\View;

use Barium\Strategy\ViewStrategy;
    
abstract class AbstractView implements ViewStrategy
{
    /*
     * Construct data.
     */
    function __construct(
        \Barium\Strategy\TemplateStrategy $TemplateStrategy, 
        \Barium\Article\Model\ArticleModel $ArticleModel
    ) {
        $this->TemplateStrategy = $TemplateStrategy;
        $this->ArticleModel = $ArticleModel;
    }
    
    function setSlug($SlugModel) 
    {
        $this->SlugModel = $SlugModel;
    }
    
    function setNav($NavModel) 
    {
        $this->NavModel = $NavModel;
    }
    
    function setLanguage($language) 
    {
        $this->language = $language;
    }
    
    /*
     * Implement the method in ViewStrategy.
     */
    function render() 
    {  
    }
}