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

        return $this->mapObject($row);
    }

    public function getBlogArticle($options = [])
    {
        $rows = $this->gateway->getRows($options);

        $entries = [];

        foreach ($rows as $row) {
            $entries[] = $this->mapObject($row);
        }

        return $entries;
    }

    /**
     * Map the data to model.
     * @param  array  $row [description]
     * @return [type]      [description]
     */
    public function mapObject(array $row)
    {
        $class = get_class($this->model);
        $model = new $class;
        $model->setArticleId($row['article_id']) ;
        $model->setTitle($row['title']);
        $model->setDescription($row['description']);
        $model->setCreatedOn($row['created_on']);
        $model->setContent(isset($row['content']) ? $row['content'] : null);
        $model->setTemplate(isset($row['template']) ? $row['template']['path'] : null);

        return $model;
    }
}
