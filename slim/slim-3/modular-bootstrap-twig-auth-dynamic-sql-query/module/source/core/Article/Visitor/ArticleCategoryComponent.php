<?php
/*
 * Handle the component
 */
namespace Spectre\Article\Component;

use Spectre\Strategy\CompositeStrategy;
use Spectre\Helper\ArrayHelpers;
use Spectre\Helper\ObjectHelpers;
use Spectre\Helper\ItemHelpers;

class ArticleCategoryComponent implements CompositeStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;
    use ItemHelpers;

    /*
     * Construct dependency.
     */
    public function __construct(\Spectre\Adapter\PdoAdapter $PdoAdapter)
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
        $category = [];

        // Set vars.
        $defaults = [
            "article_id"	=>	null
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Fetching the row that associates with the article.
        $category['category'] = $this->getCategory([
            "article_id" => $settings->article_id
        ])->removeNumbericKeys()->getItem();

        // Return the result.
        return $category;
    }

    private function getCategory($options = [])
    {
        // Set vars.
        $defaults = [
            "article_id"	=>	null
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        $sql = "
            SELECT *
            FROM article_has_category AS x

            LEFT JOIN category AS c
            ON c.category_id = x.category_id

            WHERE x.article_id = ?
        ";

        // Execute the query.
        $this->item = $this->PdoAdapter->fetchRow($sql, array(
            $settings->article_id
     ));

        // Return $this object for chaining.
        return $this;
    }
}
