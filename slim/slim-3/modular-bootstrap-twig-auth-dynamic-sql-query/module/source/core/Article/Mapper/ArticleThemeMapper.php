<?php
/*
 * Handle article request and its associates.
*/
namespace Spectre\Article\Mapper;

use Spectre\Strategy\MapperStrategy;
use Spectre\Helper\ArrayHelpers;
use Spectre\Helper\ObjectHelpers;
use Spectre\Helper\ItemHelpers;

class ArticleThemeMapper implements MapperStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;
    use ItemHelpers;

    /*
     * Set props.
     */
    protected $PdoAdapter;

    /*
     * Construct dependency.
     */
    public function __construct(\Spectre\Adapter\PdoAdapter $PdoAdapter)
    {
        // Set dependency.
        $this->PdoAdapter = $PdoAdapter;
    }

    /*
     *  Fetch row.
     */
    public function getRow($options = [])
    {
        // Set vars.
        $defaults = [
            "article_id" 	=>	null
        ];

        // Process arrays and convert the result to object.
        $setting = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Prepare the SQL.
        $sql = "
            SELECT q.*
            FROM article AS p

            LEFT JOIN query AS q
            ON q.type = 'page'
            AND q.id = p.article_id
            AND q.value IS NOT NULL

            WHERE p.url = ?
            AND q.value IS NOT NULL
        ";

        // Store the data in the local variable.
        $this->item = $this->PdoAdapter->fetchRow($sql, array(
            $setting->article_id
        ));

        // Return the entire object for Method chaining.
        return $this;
    }

    /*
     *  Map the data to model.
     */
    public function populate(\Spectre\Strategy\ModelStrategy $ModelStrategy, $options = [])
    {
        $ModelStrategy->item = $this->getRow($options)->getItem();
    }
}
