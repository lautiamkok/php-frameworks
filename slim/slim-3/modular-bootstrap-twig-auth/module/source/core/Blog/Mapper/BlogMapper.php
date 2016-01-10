<?php
namespace Barium\Blog\Mapper;

use Barium\Strategy\MapperStrategy;

use Barium\Strategy\GatewayStrategy;
use Barium\Strategy\ModelStrategy;

class BlogMapper implements MapperStrategy
{
    /**
     * Set props.
     * @var [type]
     */
    protected $gateway;
    protected $model;

    /**
     * [__construct description]
     * @param GatewayStrategy $gateway [description]
     * @param ModelStrategy   $model   [description]
     */
    public function __construct(
        GatewayStrategy $gateway,
        ModelStrategy $model
    )
    {
        $this->gateway = $gateway;
        $this->model = $model;
    }

    /**
     * [getOne description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getBlog($options = [])
    {
        $row = $this->gateway->getBlog($options);

        // Throw the error exception when no blog is found.
        if ($row === false) {
            throw new \Exception('Not found!');
        }

        return $this->mapObject($this->model, $row);
    }

    /**
     * Map the data to model.
     * @param  array  $row [description]
     * @return [type]      [description]
     */
    public function mapObject(ModelStrategy $model, array $row)
    {
        $model->setBlogId($row['article_id']) ;
        $model->setTitle($row['title']);
        $model->setContent($row['content']);
        $model->setTemplate($row['template']['path']);
        $model->setArticles(isset($row['articles']) ? $row['articles'] : []);

        return $model;
    }
}
