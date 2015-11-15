<?php
namespace Barium\Article\Model;

use Barium\Strategy\ModelStrategy;
use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;

class ArticleModel implements ModelStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;

    protected $articleId;
    protected $title;
    protected $content;
    protected $template;

    public function toArray()
    {
        return get_object_vars($this);
    }

    // Setters:

    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    // Getters:

    public function getArticleId()
    {
        return $this->articleId;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getTemplate()
    {
        return $this->template;
    }
}
