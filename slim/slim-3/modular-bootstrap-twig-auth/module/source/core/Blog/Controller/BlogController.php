<?php
namespace Barium\Blog\Controller;

use Barium\Strategy\MapperStrategy;
use Barium\Strategy\ModelStrategy;

class BlogController
{
    /**
     * [__construct description]
     * @param ModelStrategy  $Model    [description]
     * @param MapperStrategy $Mapper   [description]
     * @param MapperStrategy $Articles [description]
     */
    public function __construct(
        ModelStrategy $Model,
        MapperStrategy $Mapper,
        MapperStrategy $Articles
    )
    {
        $this->Model = $Model;
        $this->Mapper = $Mapper;
        $this->Articles = $Articles;
    }

    /**
     * [getBlog description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getBlog($options = [])
    {
        $this->Mapper->getBlog([
            "url" => $options["url"]
        ]);

        $params = array_merge([
            "parent_id" => $this->Model->getBlogId()
        ], $options["articles"]);

        $this->Model->setArticles(
            $this->Articles->getBlogArticle($params)
        );
    }
}
