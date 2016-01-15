<?php
/*
 * Handle the view of the page.
 *
 */
namespace Spectre\Article\View;

use Spectre\Strategy\ViewStrategy;

abstract class AbstractView implements ViewStrategy
{
    /*
     * Implement the method in ViewStrategy.
     */
    function render()
    {
    }
}
