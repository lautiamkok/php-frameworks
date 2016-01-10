<?php
namespace Barium\Article\Gateway;

use Barium\Strategy\GatewayStrategy;
use Barium\Strategy\CompositeStrategy;
use Barium\Strategy\ComposableStrategy;

use Barium\Adapter\PdoAdapter;

use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;
use Barium\Helper\ItemHelpers;

class ArticleGateway implements GatewayStrategy, CompositeStrategy, ComposableStrategy
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
     * Construct dependency.
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
     * Fetch row.
     * @param  array  $options [description]
     * @return [type]          [description]
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

        // Make sure there is a positive result.
        if ($item !== false) {
            // Get the components - if any added.
            $components = $this->compose([
                'article_id' => $item['article_id']
            ]);

            // Return the entire object for Method chaining.
            return array_merge($item, $components);
        }

        // Return the result.
        return $item;
    }
}
