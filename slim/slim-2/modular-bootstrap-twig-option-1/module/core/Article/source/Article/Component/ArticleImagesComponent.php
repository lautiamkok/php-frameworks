<?php
/*
 * Handle the component
 */
namespace Barium\Article\Component;

use Barium\Strategy\CompositeStrategy;
use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;
use Barium\Helper\ItemHelpers;

class ArticleImagesComponent implements CompositeStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;
    use ItemHelpers;
    
    /*
     * Construct dependency.
     */	
    public function __construct(\Barium\Adapter\PdoAdapter $PdoAdapter, $options)
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
        $images = [];

        // Set vars.
        $defaults = [
            "article_id"    => null
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Fetching the item that associates with the article.
        $images['images'] = $this->getImages(array_merge([
            "article_id"	=>	$settings->article_id
        ], $this->options))->getItems();

        // Return the result.
        return $images;
    }
    
    public function getImages($options = [])
    {
        // Set vars.
        $defaults = array(
            "article_id"        =>  null, 
            "category_id"       =>  null, 
            "randomise"         =>  false, 
            "start_row"         =>  0, 
            "limit"             =>  0, 
            "category"          =>  [
                "category_id"	=>  null, 
                "code"          =>  null
            ], 
     );

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Limit.
        $limit = $settings->limit ? 'LIMIT '.$settings->start_row.', '.$settings->limit : null;

        // Query for all images.
        $sql = "
            SELECT i.*
            FROM image AS i

            LEFT JOIN article_has_image x
            ON x.image_id = i.image_id
            
            LEFT JOIN category c
            ON c.category_id = i.category_id

            WHERE x.article_id = ?
            AND (i.category_id = ? OR c.code = ? OR c.category_id = ?)
            AND i.hide != ?

            ORDER BY IF(?, rand(), i.sort+0) ASC -- randomise --
            
            {$limit}
        ";

        // Execute the query.
        $this->items = $this->PdoAdapter->fetchRows($sql, array(
            $settings->article_id, 
            $settings->category_id, 
            $settings->category->code, 
            $settings->category->category_id, 
            '1', 
            $settings->randomise
     ));
        
        // Return $this object for chaining.
        return $this;
    }
}
