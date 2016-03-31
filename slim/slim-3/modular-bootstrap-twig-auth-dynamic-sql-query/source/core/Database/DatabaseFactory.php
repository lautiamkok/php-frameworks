<?php
namespace Spectre\Database;

class DatabaseFactory
{
    /**
     * [$databaseConfig description]
     * @var [type]
     */
    protected $databaseConfig;

    /**
     * [__construct description]
     * @param [type] $databaseConfig [description]
     */
    public function __construct($databaseConfig)
    {
        $this->databaseConfig = $databaseConfig;
    }

    /**
     * [getFactory description]
     * @param  [type] $factory [description]
     * @return [type]          [description]
     */
    public function getFactory($factory)
    {
        $factoryList = array(
            'Pdo' => '\Spectre\Database\Driver\Pdo\PdoDatabase',
        );

        if (!array_key_exists($factory, $factoryList)) {
            throw new \InvalidArgumentException("$factory is not valid type");
        }
        $factory = $factoryList[$factory];

        return new $factory($this->databaseConfig);
    }
}
