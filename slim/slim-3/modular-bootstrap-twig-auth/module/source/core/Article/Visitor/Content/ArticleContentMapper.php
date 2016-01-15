<?php
namespace Spectre\Article\Visitor\Content;

use Spectre\Mapper\AbstractMapper;
use Spectre\Strategy\GatewayStrategy;
use Spectre\Strategy\VisitableStrategy;
use Spectre\Strategy\VisitorStrategy;

class ArticleContentMapper extends AbstractMapper implements VisitorStrategy
{
    /**
     * Set props.
     * @var [type]
     */
    protected $gateway;
    protected $model = 'Spectre\Article\Visitor\Content\ArticleContentModel';

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
        $contents = $this->getCollection($visitable);
        $visitable->setContent($contents['0']->getValue());
        // $visitable->setContent1($contents['0']->getValue());
        // $visitable->setContent2($contents['1']->getValue());
        // $visitable->setContent3($contents['2']->getValue());
        // $visitable->setContent4($contents['3']->getValue());
    }

    /**
     * [getCollection description]
     * @param  [type] $visitable [description]
     * @return [type]            [description]
     */
    public function getCollection($visitable)
    {
        $collection = $this->gateway->getCollection([
            'article_id' => $visitable->getArticleId()
        ]);

        // Throw the error exception when no blog is found.
        if (!$collection) {
            throw new \Exception('Not Content found!');
        }

        return $this->mapCollection($collection);
    }
}
