<?php
namespace Spectre\Blog\Collection\Gateway;

use Spectre\Strategy\GatewayStrategy;
use Spectre\Strategy\DatabaseStrategy;

use Spectre\Helper\ArrayHelpers;
use Spectre\Helper\ObjectHelpers;
use Spectre\Helper\ItemHelpers;

class BlogCollectionGateway implements GatewayStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;
    use ItemHelpers;

    /**
     * Set props.
     * @var [type]
     */
    protected $database;
    protected $components = [];

    /**
     * [__construct description]
     * @param DatabaseStrategy $DatabaseStrategy [description]
     */
    public function __construct(DatabaseStrategy $database)
    {
        $this->database = $database;
    }

    /**
     * [getRows description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getRows($options = [])
    {
        // Set vars.
        $defaults = [
            "type"                      =>  null,
            "parent_id"                 =>  null,
            "start_row"                 =>  0,
            "limit"                     =>  0,
            "year"                      =>  null,
            "month"                     =>  null,
            "category"                  =>  [
                "category_id"           =>  null,
                "code"                  =>  null
            ],
            "user"                      =>  [
                "user_id"               =>  null,
                "code"                  =>  null
            ],
            "tag"                       =>  [
                "tag_id"                =>  null,
                "code"                  =>  null
            ],
            "randomise"                 =>  false,
            "highlight_only"            =>  false,
            "order_by_highlight"        =>  false,
            "order_by_title"            =>  false,
            "order_by_sort"             =>  false
        ];

        // Call internal method to process the array.
        $settings = $this->arrayMergeValues($defaults, $options);

        // Get the select query object.
        $query = $this->database->select();

        // Prepare query.
        $query->select('p.*');
        $query->select('p2.article_id AS parent_id');
        $query->select('p2.url AS parent_url');
        $query->select('EXTRACT(DAY FROM p.backdated_on) AS date');
        $query->select('EXTRACT(MONTH FROM p.backdated_on) AS month');
        $query->select('EXTRACT(YEAR FROM p.backdated_on) AS year');
        $query->from('article AS p');
        $query->leftJoin('article_has_category AS x2', 'x2.article_id = p.article_id');
        $query->leftJoin('category AS c2', 'c2.category_id = x2.category_id');
        $query->leftJoin('user AS u', 'u.user_id = p.created_by');
        $query->leftJoin('article_has_tag AS x3', 'x3.article_id = p.article_id');
        $query->leftJoin('tag AS t', 't.tag_id = x3.tag_id');
        $query->leftJoin('article AS p2', 'p2.article_id = p.parent_id');
        $query->where('p.parent_id', '=', $settings['parent_id']);
        $query->where('p.article_id', '!=', $settings['parent_id']);
        $query->where('p.hide', '!=', '1');
        $query->where('p.type', '=', $settings['type']);
        $query->groupBy('p.article_id');
        $query->orderBy('p.backdated_on DESC');
        $query->limit($settings['limit'], $settings['start_row']);

        $result = $this->database->fetchAll($query);

        // Return the result.
        return $result;
    }
}
