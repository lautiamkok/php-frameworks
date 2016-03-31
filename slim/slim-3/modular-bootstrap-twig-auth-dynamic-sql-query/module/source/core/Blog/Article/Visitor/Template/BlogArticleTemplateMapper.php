<?php
namespace Spectre\Blog\Article\Visitor\Template;

use Spectre\Mapper\AbstractMapper;
use Spectre\Strategy\GatewayStrategy;
use Spectre\Strategy\VisitableStrategy;
use Spectre\Strategy\VisitorStrategy;

class BlogArticleTemplateMapper extends AbstractMapper implements VisitorStrategy
{
    /**
     * Set props.
     * @var [type]
     */
    protected $gateway;
    protected $model = 'Spectre\Blog\Article\Visitor\Template\BlogArticleTemplateModel';

    /**
     * [__construct description]
     * @param GatewayStrategy $gateway [description]
     */
    public function __construct(GatewayStrategy $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * [visit description]
     * @param  VisitableStrategy $visitable [description]
     * @return [type]                       [description]
     */
    public function visit(VisitableStrategy $visitable)
    {
        $visitable->setTemplate($this->getOne($visitable));
    }

    /**
     * [getOne description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getOne($visitable)
    {
        $collection = $this->gateway->getOne([
            'article_id' => $visitable->getArticleId()
        ]);

        // Throw the error exception when no blog is found.
        if (!$collection) {
            throw new \Exception('Not template found!');
        }

        return $this->mapOne($collection);
    }
}
