<?php
namespace Barium\Article\Component\Template;

use Barium\Strategy\GatewayStrategy;

use Barium\Adapter\PdoAdapter;

use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;

class ArticleTemplateGateway implements GatewayStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;

    /**
     * [__construct description]
     * @param PdoAdapter $PdoAdapter [description]
     */
    public function __construct(PdoAdapter $PdoAdapter)
    {
        $this->PdoAdapter = $PdoAdapter;
    }

    /**
     * Implement the method in CompositeStrategy.
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getOne($options = [])
    {
        $defaults = [
            "article_id" => null
        ];

        $settings = $this->arrayMergeValues($defaults, $options);

        // Prepare query..
        $sql = "
            SELECT t.*
            FROM template AS t

            LEFT JOIN article AS a
            ON a.template_id = t.template_id

            WHERE a.article_id = ?
        ";

        // Fetching the row that associates with the article.
        return $this->PdoAdapter->fetchAll($sql, $settings['article_id']);
    }
}
