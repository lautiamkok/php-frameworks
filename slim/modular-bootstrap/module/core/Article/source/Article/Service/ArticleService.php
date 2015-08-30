<?php
namespace Barium\Article\Service;

use Barium\Service\AbstractService;

class ArticleService extends AbstractService
{
    public function fetchRow($options = [])
    {
        $this->MapperStrategy->populate($this->ModelStrategy, $options);
        return $this->ModelStrategy;
    }

    public function fetchTheme($options = [])
    {
        $this->MapperStrategy->populate($this->ModelStrategy, $options);
        return $this->ModelStrategy;
    }
}
