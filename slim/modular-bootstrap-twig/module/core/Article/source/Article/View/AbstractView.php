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
     * Implement the method in ViewStrategy.
     */
    function render()
    {
    }
}
