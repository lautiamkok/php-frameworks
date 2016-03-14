<?php
/*
 * Handle the component
 */
namespace Barium\Article\Component;

use Barium\Strategy\CompositeStrategy;
use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;
use Barium\Helper\ItemHelpers;

class ArticleScriptComponent implements CompositeStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;
    use ItemHelpers;
    
    /*
     * Construct dependency.
     */	
    public function __construct(\Barium\Adapter\PdoAdapter $PdoAdapter)
    {
        // Set dependency.
        $this->PdoAdapter = $PdoAdapter;
    }
    
    /*
     *  Implement the method in CompositeStrategy.
     */
    public function compose($options = [])
    {
        // Set vars.
        $script = [];

        // Set vars.
        $defaults = [
            "article_id" 	=>	null
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Fetching the row that associates with the article.
        $script['script'] = $this->getScript([
            "article_id" => $settings->article_id
        ])->removeNumbericKeys()->getItem();

        // Return the result.
        return $script;
    }
    
    public function getScript($options = [])
    {
        // Set vars.
        $defaults = [
            "article_id"    =>	null
        ];

        // Process arrays and convert the result to object.
        $setting = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        $sql = "
            SELECT *

            FROM article_has_script AS x

            LEFT JOIN script AS s
            ON s.script_id = x.script_id

            WHERE x.article_id = ?
            ORDER BY s.created_on DESC
        ";

        // Execute the query.
        $this->item = $this->PdoAdapter->fetchRow($sql, array(
            $setting->article_id
     ));

        // Return $this object for chaining.
        return $this;
    }
}
