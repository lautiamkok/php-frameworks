<?php
namespace Barium\Controller;

use Barium\Strategy\ControllerStrategy;
use Barium\Strategy\MapperStrategy;

abstract class AbstractController implements ControllerStrategy
{
    public function __construct(MapperStrategy $MapperStrategy)
    {
        $this->MapperStrategy = $MapperStrategy;
    }
}
