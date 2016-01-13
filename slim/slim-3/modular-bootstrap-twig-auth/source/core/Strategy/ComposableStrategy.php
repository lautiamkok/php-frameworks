<?php
namespace Barium\Strategy;

use Barium\Strategy\CompositeStrategy;

interface ComposableStrategy
{
    function addComponent(CompositeStrategy $component);
    function removeComponent(CompositeStrategy $component);
}

