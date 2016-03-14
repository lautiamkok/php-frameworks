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
}
