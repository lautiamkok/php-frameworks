<?php
namespace Barium\Blog\Gateway;

use Barium\Strategy\CompositeStrategy;
use Barium\Strategy\GatewayStrategy;
use Barium\Strategy\ComposableStrategy;

use Barium\Adapter\PdoAdapter;

use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;
use Barium\Helper\ItemHelpers;

class BlogCollectionGateway implements GatewayStrategy, CompositeStrategy, ComposableStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;
    use ItemHelpers;

    /**
     * Set props.
     * @var [type]
     */
    protected $PdoAdapter;
    protected $components = [];

    /**
     * [__construct description]
     * @param PdoAdapter $PdoAdapter [description]
     */
    public function __construct(PdoAdapter $PdoAdapter)
    {
        $this->PdoAdapter = $PdoAdapter;
    }

    /**
     * Compose the components.
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function compose($options = [])
    {
        $items = [];

        foreach ($this->components as $component) {
            $items[] = $component->compose($options);
        }

        if (count($items) > 0) {
            // Flatten the array.
            return call_user_func_array('array_merge', $items);
        }

        return $items;
    }

    /**
     * Add components.
     * @param CompositeStrategy $CompositeStrategy [description]
     */
    public function addComponent(CompositeStrategy $CompositeStrategy)
    {
        array_push($this->components, $CompositeStrategy);
    }

    /**
     * Remove components.
     * @param  CompositeStrategy $CompositeStrategy [description]
     * @return [type]                               [description]
     */
    public function removeComponent(CompositeStrategy $CompositeStrategy)
    {
        foreach($this->components as $componentKey => $componentValue) {
            if ($componentValue === $compositeStrategy) {
                unset($this->components[$componentKey]);
            }
        }
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
        $setting = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Limit.
        $limit = $setting->limit ? 'LIMIT '.$setting->start_row.', '.$setting->limit : null;

        // Prepare the SQL.
        $sql = "
            SELECT
                p.*,
                p2.article_id AS parent_id, -- If p2.article_id has a value, then it replaces p.parent_id, if it has no value, \$item['parent_id'] always returns null becaUse the requested page is a parent page itself --
                p2.url AS parent_url,
                EXTRACT(DAY FROM p.backdated_on) AS date,
                EXTRACT(MONTH FROM p.backdated_on) AS month,
                EXTRACT(YEAR FROM p.backdated_on) AS year

            FROM article AS p

            LEFT JOIN article_has_category AS x2
            ON x2.article_id = p.article_id

            LEFT JOIN category AS c2
            ON c2.category_id = x2.category_id

            LEFT JOIN user AS u
            ON u.user_id = p.created_by

            LEFT JOIN article_has_tag AS x3
            ON x3.article_id = p.article_id

            LEFT JOIN tag AS t
            ON t.tag_id = x3.tag_id

            LEFT JOIN article AS p2
            ON p2.article_id = p.parent_id

            WHERE p.parent_id = ?
            AND p.article_id != ?
            AND p.hide != ?
            AND p.type = ?
            AND IF(? REGEXP '^[0-9]+$', IF(? REGEXP '^[0-9]+$', DATE_FORMAT(p.backdated_on, '%Y %c') = ?, DATE_FORMAT(p.backdated_on, '%Y') = ?), p.article_id IS NOT NULL) -- fetch by date: year, month, year month, year  --
            AND IF(? REGEXP '^[a-z0-9\_]+$' , c2.code = ?, p.article_id IS NOT NULL) -- fetch by category: code/ category, code/ category --
            AND IF(? REGEXP '^[a-z0-9\_]+$' , u.code = ?, IF(? REGEXP '^[0-9]+$', u.user_id = ?, p.article_id IS NOT NULL)) -- fetch by user: code, code, user_id, user_id --
            AND IF(? REGEXP '^[a-z0-9\_]+$' , t.code = ?, IF(? REGEXP '^[0-9]+$', t.tag_id = ?, p.article_id IS NOT NULL)) -- fetch by tag: code, code, tag_id, tag_id --
            AND IF(?, p.highlight = '1', p.article_id IS NOT NULL) -- hightlight --

            GROUP BY p.article_id

            ORDER BY IF(?, rand(), IF(?, p.highlight, IF(?, p.title, IF(?, p.sort+10, p.backdated_on)))) DESC, p.backdated_on DESC -- randomise, order_by_highlight, order_by_title --

            {$limit}
        ";

        // Fetch rows.
        $items = $this->PdoAdapter->fetchAll($sql, array(
            $setting->parent_id,
            $setting->parent_id,
            '1',
            $setting->type,
            $setting->year,
            $setting->month,
            $setting->year.' '.$setting->month,
            $setting->year,
            strtolower(str_replace(array("-"), "_", $setting->category->code)),
            strtolower(str_replace(array("-"), "_", $setting->category->code)),
            strtolower(str_replace(array("-"), "_", $setting->user->code)),
            strtolower(str_replace(array("-"), "_", $setting->user->code)),
            $setting->user->user_id,
            $setting->user->user_id,
            strtolower(str_replace(array("-"), "_", $setting->tag->code)),
            strtolower(str_replace(array("-"), "_", $setting->tag->code)),
            $setting->tag->tag_id,
            $setting->tag->tag_id,
            $setting->highlight_only,
            $setting->randomise,
            $setting->order_by_highlight,
            $setting->order_by_title,
            $setting->order_by_sort
        ));

        // Return $this object for chaining.
        return $items;
    }
}
