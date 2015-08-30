<?php
// Abstract template.
namespace Barium\Template;

use Barium\Strategy\TemplateStrategy;

abstract class AbstractTemplate implements TemplateStrategy
{
    abstract public function render($data = []);
}