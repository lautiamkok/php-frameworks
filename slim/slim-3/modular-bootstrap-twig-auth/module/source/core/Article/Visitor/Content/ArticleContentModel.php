<?php
namespace Barium\Article\Visitor\Content;

use Barium\Strategy\ModelStrategy;

class ArticleContentModel implements ModelStrategy
{
    /**
     * [$articleId description]
     * @var [type]
     */
    protected $contentId;
    protected $categoryId;
    protected $description;
    protected $value;
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
                case 'content_id':
                    $this->setContentId($value);
                    break;
                case 'category_id':
                    $this->setCategoryId($value);
                    break;
                case 'value':
                    $this->setValue($value);
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
     * [setContentId description]
     * @param [type] $contentId [description]
     */
    public function setContentId($contentId)
    {
        $this->contentId = $contentId;

        return $this;
    }

    /**
     * [setCategoryId description]
     * @param [type] $categoryId [description]
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * [setValue description]
     * @param [type] $value [description]
     */
    public function setValue($value)
    {
        $this->value = $value;

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
     * [getContentId description]
     * @return [type] [description]
     */
    public function getContentId()
    {
        return $this->contentId;
    }

    /**
     * [getCategoryId description]
     * @return [type] [description]
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * [getValue description]
     * @return [type] [description]
     */
    public function getValue()
    {
        return $this->value;
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
