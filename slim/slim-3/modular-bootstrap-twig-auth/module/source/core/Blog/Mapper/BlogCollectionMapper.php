<?php
namespace Barium\Blog\Mapper;

use Barium\Mapper\AbstractMapper;
use Barium\Strategy\GatewayStrategy;

class BlogCollectionMapper extends AbstractMapper
{
    /**
     * Set props.
     * @var [type]
     */
    protected $gateway;
    protected $model = 'Barium\Blog\Model\BlogCollectionModel';

    /**
     * [__construct description]
     * @param GatewayStrategy $gateway [description]
     */
    public function __construct(GatewayStrategy $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * [getBlogArticle description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getBlogCollection($options = [])
    {
        $rows = $this->gateway->getRows($options);

        return $this->mapCollection($rows);
    }
}
