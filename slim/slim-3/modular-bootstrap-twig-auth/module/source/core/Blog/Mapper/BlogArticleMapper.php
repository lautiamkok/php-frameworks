<?php
namespace Barium\Blog\Mapper;

use Barium\Strategy\MapperStrategy;

use Barium\Strategy\GatewayStrategy;
use Barium\Strategy\ModelStrategy;

class BlogArticleMapper implements MapperStrategy
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
    public function getOne($options = [])
    {
        $row = $this->gateway->getOne($options);

        // Throw the error exception when no article is found.
        if ($row === false) {
            throw new \Exception('Not found!');
        }

        return $this->mapObject($this->model, $row);
    }

    /**
     * [getBlogArticle description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getBlogArticle($options = [])
    {
        $rows = $this->gateway->getRows($options);

        $entries = [];

        foreach ($rows as $row) {
            $class = get_class($this->model);
            $model = new $class;
            $entries[] = $this->mapObject($model, $row);
        }

        return $entries;
    }

    /**
     * Map the data to model.
     * @param  array  $row [description]
     * @return [type]      [description]
     */
    public function mapObject(ModelStrategy $model, array $row)
    {
        $model->setArticleId($row['article_id']) ;
        $model->setTitle($row['title']);
        $model->setDescription($row['description']);
        $model->setCreatedOn($row['created_on']);
        $model->setContent(isset($row['content']) ? $row['content'] : null);
        $model->setTemplate(isset($row['template']) ? $row['template']['path'] : null);

        return $model;
    }
}
