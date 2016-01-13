<?php
namespace Barium\Article\Component\Template;

use Barium\Strategy\ModelStrategy;

class ArticleTemplateModel implements ModelStrategy
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

    public function toArray()
    {
        return get_object_vars($this);
    }

    // Setters:

    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;

        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function setCode($code)
    {
        $this->code = $code;

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

    public function getTemplateId()
    {
        return $this->templateId;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getCode()
    {
        return $this->code;
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
