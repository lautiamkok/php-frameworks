<?php
namespace Spectre\Strategy;

use Spectre\Strategy\VisitableStrategy;

interface VisitorStrategy
{
    public function visit(VisitableStrategy $visitable);
}
