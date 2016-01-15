<?php
namespace Spectre\Strategy;

interface ObserverStrategy
{
    function onChanged(\Spectre\Strategy\ObservableStrategy $ObservableStrategy, $args);
}
