<?php
/*
 * Handle the component
 */
namespace Barium\Article\Component;

use Barium\Strategy\CompositeStrategy;
use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;
use Barium\Helper\ItemHelpers;

class ArticleContentComponent implements CompositeStrategy
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
        $content = [];

        // Set vars.
        $defaults = [
            "article_id" 	=>	null
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Fetch the content rows.
        $items_content = $this->getCotents(array(
            "article_id" 	=>	$settings->article_id
        ));

        // Re-structure the content key(code) and value.
        foreach($items_content as $index => $item) {

            // Always make the first item as 'content'.
            if($index === 0) {
                $content['content'] = $item['value'];
            }

            $content[$item['code']] = $item['value'];
        }

        // Return the result.
        return $content;
    }

    protected function getCotents($options = [])
    {
        // Set vars.
        $defaults = [
            "article_id"	=>	null
        ];

        // Process arrays and convert the result to object.
        $setting = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        $sql= "
            SELECT*
            FROM
            (
                SELECT *
                FROM category AS a
                WHERE a.type = 'content'
         ) a
            LEFT JOIN
            (
                SELECT c.*
                FROM content AS c

                LEFT JOIN article_has_content AS x
                ON x.content_id = c.content_id

                WHERE x.article_id = ?
         ) b
            ON b.category_id = a.category_id
        ";

        return $this->PdoAdapter->fetchRows($sql, array(
            $setting->article_id
        ));
    }
}
