<?php
namespace Barium\Strategy;

interface DelegatorStrategy
{
    function addDelegate(\Barium\Strategy\DelegateStrategy $DelegateStrategy);
}
