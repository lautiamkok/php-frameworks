<?php
namespace Barium\Blog\Model;

use Barium\Strategy\ModelStrategy;
use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;

class BlogModel implements ModelStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;

    protected $blogId;
    protected $title;
    protected $content;
    protected $template;
    protected $articles = [];

    public function toArray()
    {
        return get_object_vars($this);
    }

    // Setters:

    public function setBlogId($blogId)
    {
        $this->blogId = $blogId;
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

    public function setArticles($articles)
    {
        $this->articles = $articles;
    }

    // Getters:

    public function getBlogId()
    {
        return $this->blogId;
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

    public function getArticles()
    {
        return $this->articles;
    }
}
