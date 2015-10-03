<?php
namespace Barium\Article\Model;

use Barium\Strategy\ModelStrategy;
use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;

class ArticleModel implements ModelStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;

    public $articleId;
    public $title;
    public $content;
    public $template;

    public function toArray()
    {
        return get_object_vars($this);
    }
}
