<?php
namespace Barium\Blog\Controller;

use Barium\Strategy\MapperStrategy;
use Barium\Strategy\ModelStrategy;

class BlogController
{
    /**
     * [$model description]
     * @var [type]
     */
    protected $model;
    protected $mapper;
    protected $articles;

    /**
     * [__construct description]
     * @param ModelStrategy  $model    [description]
     * @param MapperStrategy $mapper   [description]
     * @param MapperStrategy $articles [description]
     */
    public function __construct(
        ModelStrategy $model,
        MapperStrategy $mapper,
        MapperStrategy $articles
    )
    {
        $this->model = $model;
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
        $this->mapper->getBlog([
            "url" => $options["url"]
        ]);

        $params = array_merge([
            "parent_id" => $this->model->getBlogId()
        ], $options["articles"]);

        $this->model->setArticles(
            $this->articles->getBlogArticle($params)
        );
    }
}
