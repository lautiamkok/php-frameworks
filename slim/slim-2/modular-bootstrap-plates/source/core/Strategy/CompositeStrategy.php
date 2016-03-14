<?php        
namespace Barium\Strategy;

interface CompositeStrategy
{
    public function compose($options = []);
}
