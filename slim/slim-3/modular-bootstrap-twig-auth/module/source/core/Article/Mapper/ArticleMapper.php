<?php
/*
 * Handle article request and its associates.
*/
namespace Barium\Article\Mapper;

use Barium\Strategy\MapperStrategy;
use Barium\Strategy\CompositeStrategy;
use Barium\Strategy\ComposableStrategy;

use Barium\Strategy\GatewayStrategy;
use Barium\Strategy\ModelStrategy;

class ArticleMapper implements MapperStrategy, CompositeStrategy, ComposableStrategy
{
    /*
     * Set props.
     */
    protected $gateway;
    protected $model;
    protected $components = [];

    /*
     * Construct dependency.
     */
    public function __construct(GatewayStrategy $GatewayStrategy, ModelStrategy $ModelStrategy)
    {
        $this->gateway = $GatewayStrategy;
        $this->model = $ModelStrategy;
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

    public function getOne($options = [])
    {
        $result = $this->gateway->getOne($options);

        // When the article is not found.
        if($result === false) {
            // Throw the error page.
            throw new \Exception('Not found!');
        }

        $row = array_merge($result, $this->compose($result));
        // $row = $result->current();

        return $this->mapObject($row);
    }

    /*
     *  Map the data to model.
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
