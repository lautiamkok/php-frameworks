<?php
namespace Barium\Blog\Model;

use Barium\Strategy\ModelStrategy;
use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;

class BlogArticleModel implements ModelStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;

    protected $articleId;
    protected $title;
    protected $description;
    protected $content;
    protected $template;
    protected $createdOn;

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

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
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

    public function getDescription()
    {
        return $this->description;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function getCreatedOn()
    {
        $this->createdOn;
    }
}
