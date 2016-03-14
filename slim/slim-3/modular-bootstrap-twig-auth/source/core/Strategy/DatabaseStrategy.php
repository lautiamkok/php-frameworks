<?php
namespace Spectre\Strategy;

use Spectre\Strategy\DatabaseStrategy;

interface DatabaseStrategy
{
    public function fetch(QueryStrategy $query);
    public function fetchAll(QueryStrategy $query);
}
