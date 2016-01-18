<?php
namespace Spectre\Database;

class DatabaseFactory
{
    public function getFactory($factory)
    {
        $factoryList = array(
            'Pdo' => '\Spectre\Database\AbstractFactory\PdoAbstractFactory',
        );

        if (!array_key_exists($factory, $factoryList)) {
            throw new \InvalidArgumentException("$factory is not valid type");
        }
        $factory = $factoryList[$factory];

        return new $factory();
    }
}
