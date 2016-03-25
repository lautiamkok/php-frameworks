<?php
namespace Spectre\ClientError\NotFound\Model;

use Spectre\Strategy\ModelStrategy;
use Spectre\Strategy\VisitableStrategy;
use Spectre\Strategy\VisitorStrategy;

class NotFoundModel implements ModelStrategy, VisitableStrategy
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
                    $this->setArticleId($value);
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
                case 'template':
                    $this->setTemplate($value);
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
     * [setArticleId description]
     * @param [type] $articleId [description]
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;

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
     * [setDescription description]
     * @param [type] $description [description]
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * [getArticleId description]
     * @return [type] [description]
     */
    public function getArticleId()
    {
        return $this->articleId;
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
     * [getDescription description]
     * @return [type] [description]
     */
    public function getDescription()
    {
        return $this->description;
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
