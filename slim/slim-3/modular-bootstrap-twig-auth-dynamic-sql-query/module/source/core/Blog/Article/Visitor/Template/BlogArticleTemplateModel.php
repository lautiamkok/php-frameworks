<?php
namespace Spectre\Blog\Article\Visitor\Template;

use Spectre\Strategy\ModelStrategy;

class BlogArticleTemplateModel implements ModelStrategy
{
    /**
     * [$articleId description]
     * @var [type]
     */
    protected $templateId;
    protected $title;
    protected $description;
    protected $path;
    protected $code;
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
                case 'template_id':
                    $this->setTemplateId($value);
                    break;
                case 'title':
                    $this->setTitle($value);
                    break;
                case 'path':
                    $this->setPath($value);
                    break;
                case 'code':
                    $this->setCode($value);
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
     * [setTemplateId description]
     * @param [type] $templateId [description]
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;

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
     * [setPath description]
     * @param [type] $path [description]
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * [setCode description]
     * @param [type] $code [description]
     */
    public function setCode($code)
    {
        $this->code = $code;

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
     * [getTemplateId description]
     * @return [type] [description]
     */
    public function getTemplateId()
    {
        return $this->templateId;
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
     * [getPath description]
     * @return [type] [description]
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * [getCode description]
     * @return [type] [description]
     */
    public function getCode()
    {
        return $this->code;
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
