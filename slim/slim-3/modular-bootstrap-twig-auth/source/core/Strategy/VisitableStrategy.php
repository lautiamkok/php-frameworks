<?php
namespace Barium\Strategy;

use Barium\Strategy\VisitorStrategy;

interface VisitableStrategy
{
    public function accept(VisitorStrategy $visitor);
}
