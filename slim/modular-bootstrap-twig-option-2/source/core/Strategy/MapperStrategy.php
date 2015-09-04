<?php        
namespace Barium\Strategy;

interface MapperStrategy
{
    public function populate(\Barium\Strategy\ModelStrategy $ModelStrategy, $options = []);
}
