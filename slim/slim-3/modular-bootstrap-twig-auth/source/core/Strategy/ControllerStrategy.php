<?php
namespace Barium\Strategy;

interface ControllerStrategy
{
    // public function setService(\Barium\Strategy\ServiceStrategy $ServiceStrategy);
    public function setMapper(\Barium\Strategy\MapperStrategy $MapperStrategy);
    public function setModel(\Barium\Strategy\ModelStrategy $ModelStrategy);
}
