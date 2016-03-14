<?php
/*
 * Handle the component
 */
namespace Barium\Article\Component;

use Barium\Strategy\CompositeStrategy;
use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;
use Barium\Helper\ItemHelpers;

class ArticleImageComponent implements CompositeStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;
    use ItemHelpers;
    
    /*
     * Construct dependency.
     */	
    public function __construct(\Barium\Adapter\PdoAdapter $PdoAdapter, $options = [])
    {
        // Set dependency.
        $this->PdoAdapter = $PdoAdapter;
        $this->options = $options;
    }
    
    /*
     *  Implement the method in CompositeStrategy.
     */
    public function compose($options = [])
    {
        // Set vars.
        $image = [];

        // Set vars.
        $defaults = [
            "article_id"    => null
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Fetching the item that associates with the article.
        $image['image'] = $this->getImage(array_merge([
            "article_id"	=>	$settings->article_id
        ], $this->options))->removeNumbericKeys()->getItem();

        // Return the result.
        return $image;
    }
    
    public function getImage($options = [])
    {
        // Set vars.
        $defaults = [
            "article_id"		=>  null, 
            "category_id"		=>  null, 
            "sort"              =>  1, 
            "hide"              =>  0, 
            "category"			=>  [
                "category_id"   =>  null, 
                "code"          =>  null
            ]
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        $sql = "
            SELECT i.*
            FROM image AS i

            LEFT JOIN article_has_image x
            ON x.image_id = i.image_id
            
            LEFT JOIN category c
            ON c.category_id = i.category_id

            WHERE x.article_id = ?
            AND (i.category_id = ? OR c.code = ? OR c.category_id = ?)
            AND i.hide = ?
            AND i.sort = ?
        ";

        // Execute the query.
        $this->item = $this->PdoAdapter->fetchRow($sql, [
            $settings->article_id, 
            $settings->category_id, 
            $settings->category->code, 
            $settings->category->category_id, 
            '0', 
            $settings->sort
        ]);
        
        // Return $this object for chaining.
        return $this;
    }
}
