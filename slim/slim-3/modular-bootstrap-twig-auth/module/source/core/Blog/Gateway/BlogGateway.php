<?php
namespace Barium\Blog\Gateway;

use Barium\Article\Gateway\ArticleGateway;

class BlogGateway extends ArticleGateway
{
    /**
     * Fetch row.
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getBlog($options = [])
    {
        // Set vars.
        $defaults = [
            "url" => null,
            "articles" => [
                "type" => "post",
                "parent_id" => null,
                "start_row" => 0,
                "limit" => 6
            ]
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayMergeValues($defaults, $options);

        $item = $this->getOne([
            'url' => $settings['url']
        ]);

        // Make sure there is a positive result.
        if ($item !== false) {
            // // Get the components - if any added.
            // $components = $this->compose([
            //     'article_id' => $item['article_id'],
            //     'articles' => [
            //         "parent_id" => $item['article_id'],
            //         "type" => $settings["articles"]["type"],
            //         "start_row" => $settings["articles"]["start_row"],
            //         "limit" => $settings["articles"]["limit"]
            //     ]
            // ]);

            // // // To add articles without composite pattern, by
            // // // Passing in the articles mapper.
            // // $item['articles'] = $this->MapperStrategy->getBlogArticle([
            // //     "type" => "post",
            // //     "parent_id" => $options['article_id'],
            // //     "start_row" => 0,
            // //     "limit" => 2
            // // ]);

            // // Return the entire object for Method chaining.
            // return array_merge($item, $components);
        }

        // Return the result.
        return $item;
    }
}
