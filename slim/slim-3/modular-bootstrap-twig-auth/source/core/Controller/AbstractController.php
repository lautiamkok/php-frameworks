<?php
namespace Barium\Controller;

use Barium\Strategy\ControllerStrategy;

abstract class AbstractController implements ControllerStrategy
{
    // public function setService(\Barium\Strategy\ServiceStrategy $ServiceStrategy)
    // {
    //     $this->ServiceStrategy = $ServiceStrategy;
    //     return $this;
    // }

    public function setMapper(\Barium\Strategy\MapperStrategy $MapperStrategy)
    {
        $this->MapperStrategy = $MapperStrategy;
        return $this;
    }

    public function setModel(\Barium\Strategy\ModelStrategy $ModelStrategy)
    {
        $this->ModelStrategy = $ModelStrategy;
        return $this;
    }
}
