<?php
// Abstract template.
namespace Spectre\Template;

use Spectre\Strategy\TemplateStrategy;

abstract class AbstractTemplate implements TemplateStrategy
{
    abstract public function render($data = []);
}
