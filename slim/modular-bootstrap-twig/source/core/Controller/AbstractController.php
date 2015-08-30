<?php 
namespace Barium\Controller;

use Barium\Strategy\ControllerStrategy;

abstract class AbstractController implements ControllerStrategy
{
    public function setService(\Barium\Strategy\ServiceStrategy $ServiceStrategy)
    {
        $this->ServiceStrategy = $ServiceStrategy;
        return $this;
    }
}