<?php
/*
 * Handle the component
 */
namespace Barium\Article\Component;

use Barium\Strategy\CompositeStrategy;
use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;
use Barium\Helper\ItemHelpers;

class ArticleAuthorComponent implements CompositeStrategy
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
        $author = [];

        // Set vars.
        $defaults = [
            "author_id" 	=>	null
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Fetching the row that associates with the article.
        $author['author'] = $this->getAuthor(array(
            "author_id" => $settings->author_id
     ))->removeNumbericKeys()->getItem();

        // Return the result.
        return $author;
    }
    
    private function getAuthor($options = []) 
    {
        // Set defaults.
        $defaults = [
            "created_by"    =>	null, 
            "code"          =>	null, 
            "gravatar"      =>  []
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Prepare query..
        $sql = "
            SELECT *
            FROM user AS u

            LEFT JOIN person AS p
            ON p.person_id = u.person_id

            WHERE IF(? REGEXP '^[0-9]+$', u.user_id = ?, IF(? REGEXP '^[a-z0-9\_]+$', u.code = ?, u.user_id IS NOT NULL)) -- created_by, created_by, code, code --
        ";

        // Execute the query.
        $this->item = $this->PdoAdapter->fetchRow($sql, array(
            $settings->created_by, 
            $settings->created_by, 
            strtolower(str_replace(array("-", " "), "_", $settings->code)), 
            strtolower(str_replace(array("-", " "), "_", $settings->code))
     ));

        // Return $this object for chaining.
        return $this;
    }
}
