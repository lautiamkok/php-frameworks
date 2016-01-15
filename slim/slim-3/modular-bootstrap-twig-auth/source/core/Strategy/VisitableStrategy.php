<?php
namespace Spectre\Strategy;

use Spectre\Strategy\VisitorStrategy;

interface VisitableStrategy
{
    public function accept(VisitorStrategy $visitor);
}
