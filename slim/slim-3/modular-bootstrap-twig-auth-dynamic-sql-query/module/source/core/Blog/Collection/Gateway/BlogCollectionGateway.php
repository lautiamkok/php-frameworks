<?php
namespace Spectre\Blog\Collection\Gateway;

use Spectre\Strategy\GatewayStrategy;
use Spectre\Strategy\DatabaseStrategy;

use Spectre\Helper\ArrayHelpers;
use Spectre\Helper\ObjectHelpers;

class BlogCollectionGateway implements GatewayStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;

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
     * @param  array  $params [description]
     * @return [type]          [description]
     */
    public function getRows(array $params = [])
    {
        // Set defaults.
        $defaults = [
            "type" => null,
            "parent_id" => null,
            "start_row" => 0,
            "limit" => 0
        ];

        // Call internal method to process the array.
        $settings = $this->arrayMergeValues($defaults, $params);

        // Get the select query object.
        $query = $this->database->select();

        // Prepare query.
        $query->select('p.*');
        $query->select('p2.article_id', 'parent_id');
        $query->select('p2.url', 'parent_url');
        $query->select('EXTRACT(DAY FROM p.backdated_on)', 'date');
        $query->select('EXTRACT(MONTH FROM p.backdated_on)', 'month');
        $query->select('EXTRACT(YEAR FROM p.backdated_on)', 'year');

        $query->from('article', 'p');

        $query->leftJoin('article_has_category', 'x2');
        $query->on('x2.article_id', '=', 'p.article_id');

        $query->leftJoin('category', 'c2');
        $query->on('c2.category_id', '=', 'x2.category_id');

        $query->leftJoin('user', 'u');
        $query->on('u.user_id', '=', 'p.created_by');

        $query->leftJoin('article_has_tag', 'x3');
        $query->on('x3.article_id', '=', 'p.article_id');

        $query->leftJoin('tag', 't');
        $query->on('t.tag_id', '=', 'x3.tag_id');

        $query->leftJoin('article', 'p2');
        $query->on('p2.article_id', '=', 'p.parent_id');

        $query->where('p.parent_id', '=', $settings['parent_id']);
        $query->where('p.article_id', '!=', $settings['parent_id']);
        $query->where('p.hide', '!=', '1');
        $query->where('p.type', '=', $settings['type']);

        if (isset($params['category'])) {
            $query->where('c2.code', '=', strtolower(str_replace(array("-"), "_", $params['category'])));
        }

        if (isset($params['tag'])) {
            $query->where('t.code', '=', strtolower(str_replace(array("-"), "_", $params['tag'])));
        }

        if (isset($params['user'])) {
            $query->where('u.code', '=', strtolower(str_replace(array("-"), "_", $params['user'])));
        }

        if (isset($params['month']) && isset($params['year'])) {
            $query->where("DATE_FORMAT(p.backdated_on, '%Y %c')", '=', $params['year'] . ' ' . $params['month']);
        } else if (isset($params['year'])) {
            $query->where("DATE_FORMAT(p.backdated_on, '%Y')", '=', $params['year']);
        }

        if (isset($params['highlight_only'])) {
            $query->where('p.highlight', '=', '1');
        }

        $query->groupBy('p.article_id');

        if (isset($params['randomise'])) {
            $query->orderBy('rand()');
        } else if (isset($params['order_by_title'])) {
            $query->orderBy('p.title');
        } else if (isset($params['order_by_sort'])) {
            $query->orderBy('p.sort+10');
        } else {
            $query->orderBy('p.backdated_on DESC');
        }

        $query->limit($settings['limit'], $settings['start_row']);

        // Inject the query object into the db to fetch rows.
        $result = $this->database->fetchAll($query);

        // Return the result.
        return $result;
    }
}
