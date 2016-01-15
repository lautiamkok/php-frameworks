<?php
/*
 * Handle the component
 */
namespace Spectre\Article\Component;

use Spectre\Strategy\CompositeStrategy;
use Spectre\Helper\ArrayHelpers;
use Spectre\Helper\ObjectHelpers;
use Spectre\Helper\ItemHelpers;
use Spectre\Article\Mapper\ArticleMapper;

class ArticleStickyComponent extends ArticleMapper implements CompositeStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;
    use ItemHelpers;

    /*
     *  Implement the method in CompositeStrategy.
     */
    public function compose($options = [])
    {
        // Set vars.
        $sticky = [];

        // Set vars.
        $defaults = [
            "parent_id"     =>  null,
            "article_id"    =>  null
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Condition for creating the sticky.
        $sticky['sticky'] = $this->getRow(array(
            "article_id" 	=>	$settings->parent_id ? $settings->parent_id : $settings->article_id
     ))->removeNumbericKeys()->getItem();

        // Return the result.
        return $sticky;
    }
}
