<?php
namespace Barium\Article\Mapper;

use Barium\Strategy\MapperStrategy;
use Barium\Strategy\GatewayStrategy;

use Barium\Article\Model\ArticleModel;

class ArticleMapper implements MapperStrategy
{
    /**
     * Set props.
     * @var [type]
     */
    protected $gateway;

    /**
     * [__construct description]
     * @param GatewayStrategy $gateway [description]
     */
    public function __construct(GatewayStrategy $gateway)
    {
        $this->gateway = $gateway;
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

    /**
     * [getRows description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getRows($options = [])
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
        $model = new ArticleModel($row);
        // $model->setArticleId($row['article_id']) ;
        // $model->setTitle($row['title']);
        // $model->setDescription($row['description']);
        // $model->setContent(isset($row['content']) ? $row['content'] : null);
        // $model->setTemplate(isset($row['template']) ? $row['template']['path'] : null);

        return $model;
    }
}
