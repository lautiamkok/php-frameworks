<?php
namespace Barium\Article\Component\Template;

use Barium\Mapper\AbstractMapper;
use Barium\Strategy\GatewayStrategy;
use Barium\Strategy\CompositeStrategy;

class ArticleTemplateMapper extends AbstractMapper implements CompositeStrategy
{
    /**
     * Set props.
     * @var [type]
     */
    protected $gateway;
    protected $model = 'Barium\Article\Component\Template\ArticleTemplateModel';

    /**
     * [__construct description]
     * @param GatewayStrategy $gateway [description]
     */
    public function __construct(GatewayStrategy $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * [compose description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function compose($options = [])
    {
        return $this->getOne($options);
    }

    /**
     * [getOne description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getOne($options = [])
    {
        $collection = $this->gateway->getOne($options);

        $template = [];

        // Throw the error exception when no blog is found.
        if (!$collection) {
            throw new \Exception('Not template found!');
        }

        $template['template'] = $this->mapOne($collection);

        return $template;
    }
}
