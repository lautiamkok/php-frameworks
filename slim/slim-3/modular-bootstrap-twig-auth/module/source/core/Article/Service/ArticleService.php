<?php
namespace Barium\Article\Service;

use Barium\Service\AbstractService;
use Barium\Strategy\MapperStrategy;
use Barium\Strategy\ComposableStrategy;
use Barium\Strategy\CompositeStrategy;

class ArticleService implements ComposableStrategy
{
    /**
     * [$model description]
     * @var [type]
     */
    protected $mapper;
    protected $components = [];

    /**
     * [__construct description]
     * @param MapperStrategy $mapper [description]
     */
    public function __construct(MapperStrategy $mapper)
    {
        $this->mapper = $mapper;
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
     * [addComponent description]
     * @param CompositeStrategy $component [description]
     */
    public function addComponent(CompositeStrategy $component)
    {
        array_push($this->components, $component);

        return $this;
    }

    /**
     * [removeComponent description]
     * @param  CompositeStrategy $component [description]
     * @return [type]                       [description]
     */
    public function removeComponent(CompositeStrategy $component)
    {
        foreach ($this->components as $componentKey => $componentValue) {
            if ($componentValue === $component) {
                unset($this->components[$componentKey]);
            }
        }
    }

    /**
     * '[getArticle description]'
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getArticle($options = [])
    {
        $model = $this->mapper->getOne($options);

        // Make sure there is a positive result.
        if ($model) {
            // Get the components - if any added.
            $components = $this->compose([
                'article_id' => $model->getArticleId()
            ]);

            foreach ($components as $key => $value) {
                // Call the method in the model - manually.
                $model->{'set'. ucfirst($key)}($value);

                // Or:
                // call_user_func_array(array($model, 'set'. $key), array($value));
            }
        }

        return $model;
    }

    /**
     * [fetchTheme description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function fetchTheme($options = [])
    {
        $this->MapperStrategy->getTheme($options);
    }
}
