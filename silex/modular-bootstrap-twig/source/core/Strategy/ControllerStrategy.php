<?php
namespace Barium\Strategy;

interface ControllerStrategy
{
    public function setService(\Barium\Strategy\ServiceStrategy $ServiceStrategy);
}
