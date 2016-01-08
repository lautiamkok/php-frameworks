<?php
namespace Barium\Article\Mapper;

use Barium\Strategy\MapperStrategy;
use Barium\Strategy\CompositeStrategy;
use Barium\Strategy\ComposableStrategy;

use Barium\Strategy\GatewayStrategy;
use Barium\Strategy\ModelStrategy;

class ArticleMapper implements MapperStrategy, CompositeStrategy, ComposableStrategy
{
    /**
     * Set props.
     * @var [type]
     */
    protected $gateway;
    protected $model;
    protected $components = [];

    /**
     * Construct dependency.
     * @param GatewayStrategy $GatewayStrategy [description]
     * @param ModelStrategy   $ModelStrategy   [description]
     */
    public function __construct(GatewayStrategy $GatewayStrategy, ModelStrategy $ModelStrategy)
    {
        $this->gateway = $GatewayStrategy;
        $this->model = $ModelStrategy;
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

        // Flatten the array.
        return call_user_func_array('array_merge', $items);
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
     * [getOne description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getOne($options = [])
    {
        $result = $this->gateway->getOne($options);

        // Throw the error exception when no article is found.
        if ($result === false) {
            throw new \Exception('Not found!');
        }

        $row = array_merge($result, $this->compose($result));
        // $row = $result->current();

        return $this->mapObject($row);
    }

    /**
     * Map the data to model.
     * @param  array  $row [description]
     * @return [type]      [description]
     */
    public function mapObject(array $row)
    {
        $this->model->setArticleId($row['article_id']) ;
        $this->model->setTitle($row['title']);
        $this->model->setContent($row['content']);
        $this->model->setTemplate($row['template']['path']);

        return $this->model;
    }
}
