<?php
namespace Barium\Strategy;

use Barium\Strategy\VisitableStrategy;

interface VisitorStrategy
{
    public function visit(VisitableStrategy $visitable);
}
