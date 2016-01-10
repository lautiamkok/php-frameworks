<?php
namespace Barium\Blog\Gateway;

use Barium\Article\Gateway\ArticleGateway;

class BlogGateway extends ArticleGateway
{
    /**
     * [getBlog description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getBlog($options = [])
    {
        $defaults = [
            "url" => null
        ];

        $settings = $this->arrayMergeValues($defaults, $options);

        $item = $this->getOne([
            'url' => $settings['url']
        ]);

        return $item;
    }
}
