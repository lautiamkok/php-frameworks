<?php
namespace Spectre\Engineer;

use Spectre\Strategy\EngineerStrategy;

abstract class AbstractEngineer implements EngineerStrategy
{
    /*
     * Implement the method in the strategy.
     */
    public function setModel(\Spectre\Strategy\ModelStrategy $ModelStrategy)
    {
        $this->model = $ModelStrategy;

        return $this;
    }

    /*
     * Implement the method in the strategy.
     */
    public function setBuilder(\Spectre\Strategy\BuilderStrategy $BuilderStrategy)
    {
        $this->builder = $BuilderStrategy;

        return $this;
    }
}
