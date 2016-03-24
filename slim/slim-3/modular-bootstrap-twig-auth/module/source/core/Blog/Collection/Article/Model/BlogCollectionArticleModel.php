<?php
namespace Spectre\Blog\Collection\Article\Model;

use Spectre\Strategy\ModelStrategy;
use Spectre\Strategy\VisitableStrategy;
use Spectre\Strategy\VisitorStrategy;

class BlogCollectionArticleModel implements ModelStrategy, VisitableStrategy
{
    /**
     * [$articleId description]
     * @var [type]
     */
    protected $articleId;
    protected $title;
    protected $description;
    protected $content;
    protected $template;
    protected $createdOn;

    /**
     * [__construct description]
     * @param array $params [description]
     */
    public function __construct(array $params = [])
    {
        $this->setOptions($params);
    }

    /**
     * [accept description]
     * @param  VisitorStrategy $visitor [description]
     * @return [type]                   [description]
     */
    public function accept(VisitorStrategy $visitor)
    {
        $visitor->visit($this);
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
                    $this->setArticleId($value);
                    break;
                case 'title':
                    $this->setTitle($value);
                    break;
                case 'description':
                    $this->setDescription($value);
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

    public function toArray()
    {
        return get_object_vars($this);
    }

    // Setters:

    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;

        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;

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
        return $this->createdOn;
    }

    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }
}
