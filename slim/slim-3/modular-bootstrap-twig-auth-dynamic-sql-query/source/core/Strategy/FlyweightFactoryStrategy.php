<?php
namespace Spectre\Strategy;

use Spectre\Strategy\FlyweightStrategy;

interface FlyweightFactoryStrategy
{
    public function addFlyweight(FlyweightStrategy $flyweight);
}
