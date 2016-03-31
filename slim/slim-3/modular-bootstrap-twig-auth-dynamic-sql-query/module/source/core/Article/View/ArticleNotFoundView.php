<?php
/*
 * Handle the view of the page.
 *
*/
namespace Spectre\Article\View;

//use Spectre\Strategy\ViewStrategy;
use Spectre\Article\View\AbstractView;

class ArticleNotFoundView extends AbstractView //implements ViewStrategy
{
    /*
     * Set props.
     */
    protected $TemplateStrategy;
    protected $SlugModel;
    protected $NavModel;
    protected $ArticleModel;
    protected $language;
    public $exceptionMessage;

    /*
     * Output.
     */
    function render()
    {
        // Render page and bind data to it.
        return $this->TemplateStrategy->render([
            "exceptionMessage"  => $this->exceptionMessage,
            "language"          => $this->language,
            "slug"              => $this->SlugModel,
            "nav"               => $this->NavModel,
            "article"           => $this->ArticleModel
        ]);
    }
}
