<?php
namespace Spectre\Strategy;

interface ServiceStrategy
{
    public function setMapper(\Spectre\Strategy\MapperStrategy $MapperStrategy);
    public function setModel(\Spectre\Strategy\ModelStrategy $ModelStrategy);
}
