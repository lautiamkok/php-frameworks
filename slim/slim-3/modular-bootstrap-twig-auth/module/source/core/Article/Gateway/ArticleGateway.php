<?php
/*
 * Handle article request and its associates.
*/
namespace Barium\Article\Gateway;

use Barium\Strategy\GatewayStrategy;
use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;
use Barium\Helper\ItemHelpers;

use Barium\Adapter\PdoAdapter;

class ArticleGateway implements GatewayStrategy
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
    public function __construct(PdoAdapter $PdoAdapter)
    {
        $this->PdoAdapter = $PdoAdapter;
    }

    /*
     *  Fetch row.
     */
    public function getOne($options = [])
    {
        // Set vars.
        $defaults = [
            "type"  => null,
            "article_id" => null,
            "url" => null,
            "hide" => 0
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayMergeValues($defaults, $options);

        // Prepare the SQL.
        $sql = "
            SELECT
                p.*,
                p2.article_id AS parent_id, -- If p2.article_id has a value, then it replaces p.parent_id, if it has no value, \$item['parent_id'] always returns null becaUse the requested page is a parent page itself --
                p2.url AS parent_url,
                p3.article_id AS parent_parent_id,
                p3.url AS parent_parent_url,
                p3.title AS parent_parent_title,
                EXTRACT(DAY FROM p.backdated_on) AS date,
                EXTRACT(MONTH FROM p.backdated_on) AS month,
                EXTRACT(YEAR FROM p.backdated_on) AS year

            FROM article AS p

            LEFT JOIN article AS p2
            ON p2.article_id = p.parent_id
            AND p.article_id <> p2.article_id

            LEFT JOIN article AS p3
            ON p3.article_id = p2.parent_id
            AND p2.article_id <> p3.article_id

            WHERE IF(?, p.article_id = ?, p.url = ?)
            AND IF(?, p.type = ?, p.article_id IS NOT NULL)
            AND p.hide = ?

            GROUP BY p.article_id

            ORDER BY p.backdated_on DESC
        ";

        // Store the data in the local variable.
        $item = $this->PdoAdapter->fetchRow($sql, [
            $settings['article_id'],
            $settings['article_id'],
            strtolower(str_replace(array("-", "_"), " ", $settings['url'])),
            $settings['type'],
            $settings['type'],
            $settings['hide']
        ]);

        // Return the entire object for Method chaining.
        return $item;
    }
}
