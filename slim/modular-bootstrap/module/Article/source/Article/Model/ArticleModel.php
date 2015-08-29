<?php
namespace Barium\Article\Model;

use Barium\Strategy\ModelStrategy;
use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;

class ArticleModel implements ModelStrategy
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
