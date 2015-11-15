<?php
/*
 * Handle the component
 */
namespace Barium\Article\Component;

use Barium\Strategy\CompositeStrategy;
use Barium\Helper\ArrayHelpers;
use Barium\Helper\ObjectHelpers;
use Barium\Helper\ItemHelpers;

class ArticleTemplateComponent implements CompositeStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;
    use ItemHelpers;

    /*
     * Construct dependency.
     */
    public function __construct(\Barium\Adapter\PdoAdapter $PdoAdapter)
    {
        // Set dependency.
        $this->PdoAdapter = $PdoAdapter;
    }

    /*
     *  Implement the method in CompositeStrategy.
     */
    public function compose($options = [])
    {
        // Set vars.
        $template = [];

        // Set vars.
        $defaults = [
            "template_id" 	=>	null
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Fetching the row that associates with the article.
        $template['template'] = $this->getTemplate(array(
            "template_id" => $settings->template_id
        ));

        // Return the result.
        return $template;
    }

    private function getTemplate($options = [])
    {
        // Set defaults.
        $defaults = [
            "template_id"	=>	null
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Prepare query..
        $sql = "
            SELECT *
            FROM template AS t
            WHERE t.template_id = ?
        ";

        // Fetch the item.
        return $this->PdoAdapter->fetchRow($sql, $settings->template_id);
    }
}
