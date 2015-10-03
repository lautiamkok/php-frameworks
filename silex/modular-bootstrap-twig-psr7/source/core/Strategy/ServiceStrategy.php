<?php
namespace Barium\Strategy;

interface ServiceStrategy
{
    public function setMapper(\Barium\Strategy\MapperStrategy $MapperStrategy);
    public function setModel(\Barium\Strategy\ModelStrategy $ModelStrategy);
}
