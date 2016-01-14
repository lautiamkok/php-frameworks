<?php
namespace Barium\Article\Visitor\Template;

use Barium\Mapper\AbstractMapper;
use Barium\Strategy\GatewayStrategy;
use Barium\Strategy\VisitableStrategy;
use Barium\Strategy\VisitorStrategy;

class ArticleTemplateMapper extends AbstractMapper implements VisitorStrategy
{
    /**
     * Set props.
     * @var [type]
     */
    protected $gateway;
    protected $model = 'Barium\Article\Visitor\Template\ArticleTemplateModel';

    /**
     * [__construct description]
     * @param GatewayStrategy $gateway [description]
     */
    public function __construct(GatewayStrategy $gateway)
    {
        $this->gateway = $gateway;
    }

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
