<?php
namespace Spectre\Article\Model;

use Spectre\Strategy\ModelStrategy;
use Spectre\Helper\ArrayHelpers;
use Spectre\Helper\ObjectHelpers;

class ArticleThemeModel implements ModelStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;

    public function respond()
    {
        $this->dataToProperty($this->item);
        unset($this->item);
    }

    public function __invoke()
    {
        $this->respond();
    }
}
