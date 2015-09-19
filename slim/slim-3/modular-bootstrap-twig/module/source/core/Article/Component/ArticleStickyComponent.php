<?php
/*
 * Handle the component
 */
namespace Barium\Article\Component;

use Barium\Strategy\CompositeStrategy;
use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;
use Barium\Helper\ItemHelpers;
use Barium\Article\Mapper\ArticleMapper;

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
