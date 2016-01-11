<?php
namespace Barium\Blog\Model;

use Barium\Strategy\ModelStrategy;

class BlogModel implements ModelStrategy
{
    /**
     * [$blogId description]
     * @var [type]
     */
    protected $blogId;
    protected $title;
    protected $content;
    protected $template;
    protected $articles = [];
    protected $createdOn;
    protected $updatedOn;

    /**
     * [__construct description]
     * @param array $params [description]
     */
    public function __construct(array $params = [])
    {
        $this->setOptions($params);
    }

    /**
     * [setOptions description]
     * @param array $params [description]
     */
    public function setOptions(array $params)
    {
        foreach ($params as $key => $value) {
            switch ($key) {
                case 'article_id':
                    $this->setBlogId($value);
                    break;
                case 'title':
                    $this->setTitle($value);
                    break;
                case 'content':
                    $this->setContent($value);
                    break;
                case 'articles':
                    $this->setArticles($value);
                    break;
                case 'creator':
                    $this->setCreator($value);
                    break;
                case 'created_on':
                    $this->setCreatedOn($value);
                    break;
                case 'updated_on':
                    $this->setUpdatedOn($value);
                    break;
            }
        }
    }

    /**
     * [toArray description]
     * @return [type] [description]
     */
    public function toArray()
    {
        return get_object_vars($this);
    }

    // Setters:

    public function setBlogId($blogId)
    {
        $this->blogId = $blogId;

        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    public function setArticles($articles)
    {
        $this->articles = $articles;

        return $this;
    }

    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
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

    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }
}
