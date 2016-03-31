<?php
namespace Spectre\Blog\Service;

use Spectre\Strategy\MapperStrategy;

class BlogService
{
    /**
     * [$model description]
     * @var [type]
     */
    protected $blog;
    protected $collection;

    /**
     * [__construct description]
     * @param MapperStrategy $blog   [description]
     * @param MapperStrategy $collection [description]
     */
    public function __construct(
        MapperStrategy $blog,
        MapperStrategy $collection
    )
    {
        $this->blog = $blog;
        $this->collection = $collection;
    }

    /**
     * [getBlog description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getBlog($options = [])
    {
        // Get blog model.
        $blog = $this->blog->getBlog([
            "url" => $options["url"]
        ]);

        $params = array_merge([
            "parent_id" => $blog->getBlogId()
        ], $options["collection"]);

        // Get blog collection model.
        $collection = $this->collection->getBlogCollection($params);

        // Store blog model with its collection.
        $result = $blog->setCollection($collection);

        // Return the blog model.
        return $result;
    }
}
