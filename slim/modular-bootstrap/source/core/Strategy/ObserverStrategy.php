<?php
namespace Barium\Strategy;

interface ObserverStrategy
{
    function onChanged(\Barium\Strategy\ObservableStrategy $ObservableStrategy, $args);
}
