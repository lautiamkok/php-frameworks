<?php
namespace Spectre\ClientError\NotFound\Service;

use Spectre\Service\AbstractService;
use Spectre\Strategy\MapperStrategy;

class NotFoundService
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
     * '[getNotFound description]'
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getNotFound($options = [])
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
