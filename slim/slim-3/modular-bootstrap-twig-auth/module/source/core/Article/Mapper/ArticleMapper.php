<?php
/*
 * Handle article request and its associates.
*/
namespace Barium\Article\Mapper;

use Barium\Strategy\MapperStrategy;
use Barium\Strategy\CompositeStrategy;
use Barium\Strategy\ComposableStrategy;

class ArticleMapper implements MapperStrategy, CompositeStrategy, ComposableStrategy
{
    /*
     * Set props.
     */
    protected $gateway;
    protected $components = [];

    /*
     * Construct dependency.
     */
    public function __construct(\Barium\Strategy\GatewayStrategy $GatewayStrategy)
    {
        $this->gateway = $GatewayStrategy;
    }

    /*
     *  Compose the components.
     */
    public function compose($options = [])
    {
        $items = [];

        foreach ($this->components as $component) {
            $items[] = $component->compose($options);
        }

        // Flatten the array.
        return call_user_func_array('array_merge', $items);
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
        foreach($this->components as $componentKey => $componentValue) {
            if ($componentValue === $compositeStrategy) {
                unset($this->components[$componentKey]);
            }
        }
    }

    /*
     *  Map the data to model.
     */
    public function populate(\Barium\Strategy\ModelStrategy $ModelStrategy, $options = [])
    {
        $row = $this->gateway->getRow($options);
        $item = array_merge($row, $this->compose($row));

        $ModelStrategy->setArticleId($item['article_id']) ;
        $ModelStrategy->setTitle($item['title']);
        $ModelStrategy->setContent($item['content']);
        $ModelStrategy->setTemplate($item['template']['path']);
    }
}
