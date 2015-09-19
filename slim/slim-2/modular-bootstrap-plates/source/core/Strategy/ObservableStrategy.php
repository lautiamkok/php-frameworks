<?php
namespace Barium\Strategy;

interface ObservableStrategy
{
    function addObserver(\Barium\Strategy\ObserverStrategy $ObserverStrategy);
    function removeObserver(\Barium\Strategy\ObserverStrategy $ObserverStrategy);
    function notifyObserver($args);
}
