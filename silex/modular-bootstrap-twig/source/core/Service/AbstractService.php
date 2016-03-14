<?php
namespace Barium\Service;

use Barium\Strategy\ServiceStrategy;

class AbstractService implements ServiceStrategy
{
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