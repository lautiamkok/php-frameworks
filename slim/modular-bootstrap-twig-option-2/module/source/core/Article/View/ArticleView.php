<?php
/*
 * Handle the view of the page.
 *
 */
namespace Barium\Article\View;

use Barium\Article\View\AbstractView;
use Barium\Article\Model\ArticleModel;

class ArticleView extends AbstractView
{
    public $model;

    /*
     * Construct data.
     */
    function __construct(ArticleModel $ArticleModel)
    {
        $this->model = $ArticleModel;
    }

    function render()
    {
        // Render page and bind data to it.
        return '<h1>' . $this->model->title .'</h1>';
    }
}
