<?php
namespace Spectre\Blog\Model;

use Spectre\Strategy\ModelStrategy;
use Spectre\Strategy\VisitableStrategy;
use Spectre\Strategy\VisitorStrategy;

class BlogModel implements ModelStrategy, VisitableStrategy
{
    /**
     * [$blogId description]
     * @var [type]
     */
    protected $blogId;
    protected $title;
    protected $content;
    protected $template;
    protected $collection = [];
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
                    $this->setBlogId($value);
                    break;
                case 'title':
                    $this->setTitle($value);
                    break;
                case 'content':
                    $this->setContent($value);
                    break;
                case 'collection':
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

    /**
     * [setBlogId description]
     * @param [type] $blogId [description]
     */
    public function setBlogId($blogId)
    {
        $this->blogId = $blogId;

        return $this;
    }

    /**
     * [setTitle description]
     * @param [type] $title [description]
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * [setContent description]
     * @param [type] $content [description]
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * [setTemplate description]
     * @param [type] $template [description]
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * [setArticles description]
     * @param [type] $collection [description]
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * [setCreatedOn description]
     * @param [type] $createdOn [description]
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * [setUpdatedOn description]
     * @param [type] $updatedOn [description]
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    // Getters:

    /**
     * [getBlogId description]
     * @return [type] [description]
     */
    public function getBlogId()
    {
        return $this->blogId;
    }

    /**
     * [getTitle description]
     * @return [type] [description]
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * [getContent description]
     * @return [type] [description]
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * [getTemplate description]
     * @return [type] [description]
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * [getArticles description]
     * @return [type] [description]
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * [getCreatedOn description]
     * @return [type] [description]
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * [getUpdatedOn description]
     * @return [type] [description]
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }
}
