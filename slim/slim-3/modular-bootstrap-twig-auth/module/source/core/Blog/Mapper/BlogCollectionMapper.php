<?php
namespace Spectre\Blog\Mapper;

use Spectre\Mapper\AbstractMapper;
use Spectre\Strategy\GatewayStrategy;

class BlogCollectionMapper extends AbstractMapper
{
    /**
     * Set props.
     * @var [type]
     */
    protected $gateway;
    protected $model = 'Spectre\Blog\Model\BlogCollectionArticleModel';

    /**
     * [__construct description]
     * @param GatewayStrategy $gateway [description]
     */
    public function __construct(GatewayStrategy $gateway)
    {
        $this->gateway = $gateway;
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
        foreach ($collecton as $item) {
            $item->accept($options["visitor"]);
            $newCollection[] = $item;
        }

        // Return the new result.
        return $newCollection;
    }
}
