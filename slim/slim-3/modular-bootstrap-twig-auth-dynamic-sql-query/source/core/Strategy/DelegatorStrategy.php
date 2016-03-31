<?php
namespace Spectre\Strategy;

interface DelegatorStrategy
{
    function addDelegate(\Spectre\Strategy\DelegateStrategy $DelegateStrategy);
}
