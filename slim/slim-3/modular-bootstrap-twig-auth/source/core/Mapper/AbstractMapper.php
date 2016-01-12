<?php
namespace Barium\Mapper;

use Barium\Strategy\MapperStrategy;

abstract class AbstractMapper implements MapperStrategy
{
    /**
     * [mapOne description]
     * @param  array  $row [description]
     * @return [type]      [description]
     */
    protected function mapOne(array $rows = [])
    {
        $returnOne = null;

        // Throw the error exception when no article is found.
        if ($rows !== false) {
            $returnOne = $this->mapObject(array_pop($rows));
        }

        return $returnOne;
    }

    /**
     * [mapCollection description]
     * @param  array  $rows [description]
     * @return [type]       [description]
     */
    protected function mapCollection(array $rows = [])
    {
        $collection = [];

        foreach ($rows as $row) {
            $collection[] = $this->mapObject($row);
        }

        return $collection;
    }

    /**
     * [mapObject description]
     * @param  array  $row [description]
     * @return [type]      [description]
     */
    protected function mapObject(array $row)
    {
        $model = new $this->model($row);

        return $model;
    }
}
