<?php
namespace Spectre\Article\Visitor\Template;

use Spectre\Strategy\GatewayStrategy;
use Spectre\Strategy\DatabaseStrategy;

use Spectre\Helper\ArrayHelpers;
use Spectre\Helper\ObjectHelpers;

class ArticleTemplateGateway implements GatewayStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;

    /**
     * [__construct description]
     * @param DatabaseStrategy $database [description]
     */
    public function __construct(DatabaseStrategy $database)
    {
        $this->database = $database;
    }

    /**
     * [getOne description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getOne($options = [])
    {
        $defaults = [
            "article_id" => null
        ];

        $settings = $this->arrayMergeValues($defaults, $options);

        // Get the select query object.
        $query = $this->database->select();

        // Prepare query.
        $query->select('t.*');
        $query->from('template AS t');
        $query->leftJoin('article AS a', 'a.template_id = t.template_id');
        $query->where('a.article_id', '=', $settings['article_id']);

        // Fetching the row that associates with the article.
        $result = $this->database->fetchAll($query);

        // Return the result.
        return $result;
    }
}
