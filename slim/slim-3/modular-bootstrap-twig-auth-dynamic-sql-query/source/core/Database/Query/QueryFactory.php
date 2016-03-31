<?php

namespace Spectre\Database\Query;

use Spectre\Database\Query\MySQL\Select\SelectQuery as Select;
use Spectre\Database\Query\MySQL\Insert\InsertQuery as Insert;
use Spectre\Database\Query\MySQL\Update\UpdateQuery as Update;
use Spectre\Database\Query\MySQL\Delete\DeleteQuery as Delete;

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
    }
}
