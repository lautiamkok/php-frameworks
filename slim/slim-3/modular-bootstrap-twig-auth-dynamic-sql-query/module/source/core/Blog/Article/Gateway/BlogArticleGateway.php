<?php
namespace Spectre\Blog\Article\Gateway;

use Spectre\Strategy\GatewayStrategy;
use Spectre\Strategy\DatabaseStrategy;

use Spectre\Helper\ArrayHelpers;
use Spectre\Helper\ObjectHelpers;

class BlogArticleGateway implements GatewayStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;

    /**
     * [$database description]
     * @var [type]
     */
    protected $database;

    /**
     * Construct dependency.
     * @param DatabaseStrategy $database [description]
     */
    public function __construct(DatabaseStrategy $database)
    {
        $this->database = $database;
    }

    /**
     * Fetch row.
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getOne($options = [])
    {
        // Set vars.
        $defaults = [
            "type"  => 'post',
            "article_id" => null,
            "url" => null,
            "hide" => 0
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayMergeValues($defaults, $options);

        // Get the select query object.
        $query = $this->database->select();

        // Prepare query.
        $query->select('p.*');
        $query->select('p2.article_id AS parent_id');
        $query->select('p2.url AS parent_url');
        $query->select('p3.article_id AS parent_parent_id');
        $query->select('p3.url AS parent_parent_url');
        $query->select('p3.title AS parent_parent_title');
        $query->from('article AS p');
        $query->leftJoin('article AS p2', 'p2.article_id = p.parent_id');
        $query->joinAnd('p.article_id', '<>','p2.article_id');
        $query->leftJoin('article AS p3', 'p3.article_id = p2.parent_id');
        $query->joinAnd('p2.article_id', '<>', 'p3.article_id');
        $query->where('p.url', '=', strtolower(str_replace(array("-", "_"), " ", $settings['url'])));
        $query->where('p.type', '=', $settings['type']);
        $query->where('p.hide', '=', $settings['hide']);
        $query->groupBy('p.article_id');
        $query->orderBy('p.backdated_on DESC');

        $result = $this->database->fetchAll($query);

        // Return the result.
        return $result;
    }
}
