<?php
namespace Spectre\Strategy;

interface ObservableStrategy
{
    function addObserver(\Spectre\Strategy\ObserverStrategy $ObserverStrategy);
    function removeObserver(\Spectre\Strategy\ObserverStrategy $ObserverStrategy);
    function notifyObserver($args);
}
