<?php
namespace Barium\Strategy;

interface ComposableStrategy
{
    function addComponent(\Barium\Strategy\CompositeStrategy $CompositeStrategy);
    function removeComponent(\Barium\Strategy\CompositeStrategy $CompositeStrategy);
}

