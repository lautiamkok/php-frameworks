<?php 
namespace Barium\Engineer;

use Barium\Strategy\EngineerStrategy;

abstract class AbstractEngineer implements EngineerStrategy
{
    /*
     * Implement the method in the strategy.
     */
    public function setModel(\Barium\Strategy\ModelStrategy $ModelStrategy) 
    {
        $this->model = $ModelStrategy;

        return $this;
    }

    /*
     * Implement the method in the strategy.
     */
    public function setBuilder(\Barium\Strategy\BuilderStrategy $BuilderStrategy)
    {
        $this->builder = $BuilderStrategy;

        return $this;
    }
}