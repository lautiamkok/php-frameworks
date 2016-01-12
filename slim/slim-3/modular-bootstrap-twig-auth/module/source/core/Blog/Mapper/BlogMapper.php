<?php
namespace Barium\Blog\Mapper;

use Barium\Mapper\AbstractMapper;
use Barium\Strategy\GatewayStrategy;

class BlogMapper extends AbstractMapper
{
    /**
     * Set props.
     * @var [type]
     */
    protected $gateway;
    protected $model = 'Barium\Blog\Model\BlogModel';

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
        $collection = $this->gateway->getBlog($options);

        // Throw the error exception when no blog is found.
        if ($collection === false) {
            throw new \Exception('Not found!');
        }

        return $this->mapOne($collection);
    }
}
