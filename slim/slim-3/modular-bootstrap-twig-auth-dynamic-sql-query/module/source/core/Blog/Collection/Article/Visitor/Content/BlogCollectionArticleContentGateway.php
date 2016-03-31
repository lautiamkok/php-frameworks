<?php
namespace Spectre\Blog\Collection\Article\Visitor\Content;

use Spectre\Strategy\GatewayStrategy;
use Spectre\Strategy\DatabaseStrategy;

use Spectre\Helper\ArrayHelpers;
use Spectre\Helper\ObjectHelpers;

class BlogCollectionArticleContentGateway implements GatewayStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;

    /**
     * [__construct description]
     * @param DatabaseStrategy $database [description]
     */
    public function __construct(DatabaseStrategy $database)
    {
        $this->database = $database;
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

        // Get the select query object.
        $query1 = $this->database->select();

        // Prepare query.
        $query1->select('*');
        $query1->from('category AS a');
        $query1->where('a.type', '=', 'content');

        // Get the select query object.
        $query2 = $this->database->select();

        // Prepare query.
        $query2->select('c.*');
        $query2->from('content AS c');
        $query2->leftJoin('article_has_content AS x', 'x.content_id = c.content_id');
        $query2->where('x.article_id', '=', $settings['article_id']);

        // Get the select query object.
        $query = $this->database->select();

        // Prepare query.
        $query->select('b.*');
        $query->nestFrom($query1, 'a');
        $query->nestLeftJoin($query2, 'b', 'b.category_id = a.category_id');

        // Fetching the row that associates with the article.
        $result = $this->database->fetchAll($query);

        // Return the result.
        return $result;
    }
}
