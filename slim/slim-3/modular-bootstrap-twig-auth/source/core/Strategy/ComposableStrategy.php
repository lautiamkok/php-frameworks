<?php
namespace Spectre\Strategy;

use Spectre\Strategy\CompositeStrategy;

interface ComposableStrategy
{
    function addComponent(CompositeStrategy $component);
    function removeComponent(CompositeStrategy $component);
}

