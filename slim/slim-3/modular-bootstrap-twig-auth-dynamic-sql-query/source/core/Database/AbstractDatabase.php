<?php
namespace Spectre\Database;

use Spectre\Strategy\DatabaseStrategy;
use Spectre\Database\Query\QueryFactory;

abstract class AbstractDatabase implements DatabaseStrategy
{
    public function query($factory)
    {
        $QueryFactory = new QueryFactory();
        return $QueryFactory->getFactory($factory);
    }

    public function select()
    {
        return $this->query('select');
    }

    public function insert()
    {
        return $this->query('insert');
    }

    public function update()
    {
        return $this->query('update');
    }

    public function delete()
    {
        return $this->query('delete');
    }
}
