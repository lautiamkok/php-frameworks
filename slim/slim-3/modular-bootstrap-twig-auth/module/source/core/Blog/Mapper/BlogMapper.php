<?php
namespace Barium\Blog\Mapper;

use Barium\Strategy\MapperStrategy;
use Barium\Strategy\GatewayStrategy;

use Barium\Blog\Model\BlogModel;

class BlogMapper implements MapperStrategy
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
    public function getBlog($options = [])
    {
        $row = $this->gateway->getBlog($options);

        // Throw the error exception when no blog is found.
        if ($row === false) {
            throw new \Exception('Not found!');
        }

        return $this->mapObject($row);
    }

    /**
     * Map the data to model.
     * @param  array  $row [description]
     * @return [type]      [description]
     */
    public function mapObject(array $row)
    {
        $model = new BlogModel($row);
        // $model->setBlogId($row['article_id']) ;
        // $model->setTitle($row['title']);
        // $model->setContent($row['content']);
        // $model->setTemplate($row['template']['path']);
        // $model->setArticles(isset($row['articles']) ? $row['articles'] : []);

        return $model;
    }
}
