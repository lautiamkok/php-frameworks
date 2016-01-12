<?php
namespace Barium\Article\Mapper;

use Barium\Mapper\AbstractMapper;
use Barium\Strategy\GatewayStrategy;

class ArticleMapper extends AbstractMapper
{
    /**
     * Set props.
     * @var [type]
     */
    protected $gateway;
    protected $model = 'Barium\Article\Model\ArticleModel';

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
        $collection = $this->gateway->getOne($options);

        // Throw the error exception when no blog is found.
        if (!$collection) {
            throw new \Exception('Not page found!');
        }

        return $this->mapOne($collection);
    }
}
