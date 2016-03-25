<?php
namespace Spectre\Blog\Collection\Mapper;

use Spectre\Mapper\AbstractMapper;
use Spectre\Strategy\GatewayStrategy;
use Spectre\Strategy\VisitorStrategy;
use Spectre\Strategy\FlyweightStrategy;
use Spectre\Strategy\FlyweightFactoryStrategy;

class BlogCollectionMapper extends AbstractMapper implements FlyweightFactoryStrategy
{
    /**
     * Set props.
     * @var [type]
     */
    protected $gateway;
    protected $visitors = [];
    protected $model = 'Spectre\Blog\Collection\Article\Model\BlogCollectionArticleModel';

    /**
     * [__construct description]
     * @param GatewayStrategy $gateway [description]
     */
    public function __construct(GatewayStrategy $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * [addFlyweight description]
     * @param FlyweightStrategy $visitor [description]
     */
    public function addFlyweight(FlyweightStrategy $visitor)
    {
        array_push($this->visitors, $visitor);
    }

    /**
     * [getBlogCollection description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getBlogCollection($options = [])
    {
        // Get all rows from the gateway.
        $rows = $this->gateway->getRows($options);

        // Map all rows to collection model..
        $collecton = $this->mapCollection($rows);

        // Set a new empty array.
        $newCollection = [];

        // Loop the collection's article model to inject the visitor.
        foreach ($collecton as $collectonArticle) {
            // Loop all added visitors.
            foreach ($this->visitors as $visitor) {
                $collectonArticle->accept($visitor);
            }
            $newCollection[] = $collectonArticle;
        }

        // Return the new result.
        return $newCollection;
    }
}
