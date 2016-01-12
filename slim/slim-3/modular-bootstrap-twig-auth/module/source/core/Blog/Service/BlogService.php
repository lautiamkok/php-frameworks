<?php
namespace Barium\Blog\Service;

use Barium\Strategy\MapperStrategy;

class BlogService
{
    /**
     * [$model description]
     * @var [type]
     */
    protected $mapper;
    protected $articles;

    /**
     * [__construct description]
     * @param MapperStrategy $mapper   [description]
     * @param MapperStrategy $articles [description]
     */
    public function __construct(
        MapperStrategy $mapper,
        MapperStrategy $articles
    )
    {
        $this->mapper = $mapper;
        $this->articles = $articles;
    }

    /**
     * [getBlog description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getBlog($options = [])
    {
        $model = $this->mapper->getBlog([
            "url" => $options["url"]
        ]);

        $params = array_merge([
            "parent_id" => $model->getBlogId()
        ], $options["articles"]);

        $result = $model->setArticles(
            $this->articles->getBlogCollection($params)
        );

        return $result;
    }
}
