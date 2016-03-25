<?php
namespace Spectre\ClientError\NotFound\Mapper;

use Spectre\Mapper\AbstractMapper;
use Spectre\Strategy\GatewayStrategy;

class NotFoundMapper extends AbstractMapper
{
    /**
     * Set props.
     * @var [type]
     */
    protected $gateway;
    protected $model = 'Spectre\ClientError\NotFound\Model\NotFoundModel';

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
            throw new \Exception('No page found!');
        }

        return $this->mapOne($collection);
    }
}
