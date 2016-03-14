<?php

namespace Spectre\Database\Query;

use Spectre\Database\Query\AbstractFactory\SelectAbstractFactory as Select;
use Spectre\Database\Query\AbstractFactory\InsertAbstractFactory as Insert;
use Spectre\Database\Query\AbstractFactory\UpdateAbstractFactory as Update;
use Spectre\Database\Query\AbstractFactory\DeleteAbstractFactory as Delete;

class QueryFactory
{
    /**
     * [query description]
     * @param  [type] $factory [description]
     * @return [type]          [description]
     */
    public function getFactory($factory)
    {
        switch ($factory) {
            case 'select':
                return new Select();
                break;
            case 'insert':
                return new Insert();
                break;
            case 'update':
                return new Update();
                break;
            case 'delete':
                return new Delete();
                break;
        }

        throw new \InvalidArgumentException("$factory is not valid type");

        // $factoryList = array(
        //     'select' => '\Spectre\Database\Query\AbstractFactory\SelectAbstractFactory',
        //     'insert' => '\Spectre\Database\Query\AbstractFactory\InsertAbstractFactory',
        //     'update' => '\Spectre\Database\Query\AbstractFactory\UpdateAbstractFactory',
        //     'delete' => '\Spectre\Database\Query\AbstractFactory\DeleteAbstractFactory',
        // );

        // if (!array_key_exists($factory, $factoryList)) {
        //     throw new \InvalidArgumentException("$factory is not valid type");
        // }
        // $factory = $factoryList[$factory];

        // return new $factory();
    }
}
