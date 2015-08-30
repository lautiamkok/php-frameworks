<?php
/*
 * Handle the view of the page.
 *
*/ 
namespace Barium\Article\View;

//use Barium\Strategy\ViewStrategy;
use Barium\Article\View\AbstractView;
    
class ArticleView extends AbstractView //implements ViewStrategy
{
    /*
     * Set props.
     */
    protected $TemplateStrategy;
    protected $SlugModel;
    protected $NavModel;
    protected $ArticleModel;
    protected $language;
    protected $globalError;
    
    /*
     * Output.
     */
    function render() 
    {
        // Render page and bind data to it.
        return $this->TemplateStrategy->render([
            "globalError"   => $this->globalError,
            "language"      => $this->language,
            "slug"          => $this->SlugModel,
            "nav"           => $this->NavModel,
            "article"       => $this->ArticleModel
        ]);
    }
}