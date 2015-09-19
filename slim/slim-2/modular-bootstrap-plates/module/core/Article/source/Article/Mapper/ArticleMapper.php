<?php
/*
 * Handle article request and its associates.
*/
namespace Barium\Article\Mapper;

use Barium\Strategy\MapperStrategy;
use Barium\Strategy\CompositeStrategy;
use Barium\Strategy\ComposableStrategy;
use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;
use Barium\Helper\ItemHelpers;

class ArticleMapper implements MapperStrategy, CompositeStrategy, ComposableStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;
    use ItemHelpers;

    /*
     * Set props.
     */
    protected $PdoAdapter;
    public $language;
    public $item;
    private $components = [];

    /*
     * Construct dependency.
     */
    public function __construct(\Barium\Adapter\PdoAdapter $PdoAdapter)
    {
        // Set dependency.
        $this->PdoAdapter = $PdoAdapter;
    }

    /*
     *  Compose the components.
     */
    public function compose($options = [])
    {
        foreach ($this->components as $component)
        {
            $this->item = array_merge($this->item, $component->compose($this->item));
        }

        return $this;
    }

    /*
     *  Add components.
     */
    public function addComponent(\Barium\Strategy\CompositeStrategy $CompositeStrategy)
    {
        array_push($this->components, $CompositeStrategy);
    }

    /*
     *  Remove components.
     */
    public function removeComponent(\Barium\Strategy\CompositeStrategy $CompositeStrategy)
    {
        foreach($this->components as $componentKey => $componentValue)
        {
            if ($componentValue === $compositeStrategy)
            {
                unset($this->components[$componentKey]);
            }
        }
    }

    /*
     *  Fetch row.
     */
    public function getRow($options = [])
    {
        // Set vars.
        $defaults = [
            "type"  => null,
            "article_id" => null,
            "url" => null,
            "hide" => 0
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

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
        $this->item = $this->PdoAdapter->fetchRow($sql, array(
            $settings->article_id,
            $settings->article_id,
            strtolower(str_replace(array("-", "_"), " ", $settings->url)),
            $settings->type,
            $settings->type,
            $settings->hide
        ));

        // When the article is not found.
        if($this->item === false){

            // Throw the error page.
            throw new \Barium\Exception\PageNotFoundException('Not found!', $this->PdoAdapter);
        }

        // Return the entire object for Method chaining.
        return $this;
    }

    /*
     *  Map the data to model.
     */
    public function populate(\Barium\Strategy\ModelStrategy $ModelStrategy, $options = [])
    {
        $item = $this->getRow($options)->removeNumbericKeys()->compose()->getItem();

        $ModelStrategy->articleId = $item['article_id'];
        $ModelStrategy->title = $item['title'];
        $ModelStrategy->content = $item['content'];
    }
}
