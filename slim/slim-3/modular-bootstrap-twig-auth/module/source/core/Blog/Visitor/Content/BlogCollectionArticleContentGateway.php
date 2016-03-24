<?php
namespace Spectre\Blog\Visitor\Content;

use Spectre\Strategy\GatewayStrategy;

use Spectre\Adapter\PdoAdapter;

use Spectre\Helper\ArrayHelpers;
use Spectre\Helper\ObjectHelpers;

class BlogCollectionArticleContentGateway implements GatewayStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;

    /**
     * [__construct description]
     * @param PdoAdapter $PdoAdapter [description]
     */
    public function __construct(PdoAdapter $PdoAdapter)
    {
        $this->PdoAdapter = $PdoAdapter;
    }

    /**
     * [getCollection description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getCollection($options = [])
    {
        $defaults = [
            "article_id" => null
        ];

        $settings = $this->arrayMergeValues($defaults, $options);

        // Prepare query.
        $sql= "
            SELECT b.*
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

        // Fetching the rows that associate with the article.
        return $this->PdoAdapter->fetchAll($sql, $settings['article_id']);
    }
}
