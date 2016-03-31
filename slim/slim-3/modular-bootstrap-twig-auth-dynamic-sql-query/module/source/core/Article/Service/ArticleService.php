<?php
namespace Spectre\Article\Service;

use Spectre\Service\AbstractService;
use Spectre\Strategy\MapperStrategy;

class ArticleService
{
    /**
     * [$model description]
     * @var [type]
     */
    protected $mapper;
    protected $components = [];

    /**
     * [__construct description]
     * @param MapperStrategy $mapper [description]
     */
    public function __construct(MapperStrategy $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * '[getArticle description]'
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getArticle($options = [])
    {
        $model = $this->mapper->getOne($options);

        return $model;
    }

    /**
     * [fetchTheme description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function fetchTheme($options = [])
    {
        $this->MapperStrategy->getTheme($options);
    }
}
