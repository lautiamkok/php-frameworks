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

class ArticleParentComponent extends ArticleMapper implements CompositeStrategy
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
        $parent = [];

        // Set vars.
        $defaults = [
            "parent_id"     =>  null
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Condition for creating the parent.
        if($settings->parent_id !== null)
        {
            $parent['parent'] = $this->getRow([
                "article_id" 	=>	$settings->parent_id
            ])->removeNumbericKeys()->getItem();
        }

        // Return the result.
        return $parent;
    }
}
