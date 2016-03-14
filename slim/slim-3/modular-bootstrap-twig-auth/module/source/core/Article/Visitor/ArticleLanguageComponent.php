<?php
/*
 * Handle the component
 */
namespace Spectre\Article\Component;

use Spectre\Strategy\CompositeStrategy;
use Spectre\Helper\ArrayHelpers;
use Spectre\Helper\ObjectHelpers;
use Spectre\Helper\ItemHelpers;

class ArticleLanguageComponent implements CompositeStrategy
{
    use ArrayHelpers;
    use ObjectHelpers;
    use ItemHelpers;

    /*
     * Construct dependency.
     */
    public function __construct(\Spectre\Adapter\PdoAdapter $PdoAdapter)
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
        $language = [];

        // Set vars.
        $defaults = [
            "code"          =>	null,
            "article_id"	=>	null
        ];

        // Process arrays and convert the result to object.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Condition for creating the language.
        if($settings->code !== null)
        {
            // Fetching the item that associates with the article.
            $language = $this->getLanguage(array(
                "article_id"    =>  $settings->article_id,
                "code"          =>  $settings->code
         ))->getItem();
        }

        // Return the result.
        return $language;
    }

    public function getLanguage($options = [])
    {
        // Set vars.
        $defaults = [
            "code"          =>	null,
            "article_id"	=>	null
        ];

        // Process arrays and convert the result to object.
        $setting = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        // Set empty array.
        $content = [];

        $sql_attribute = "
            SELECT
                px.*

            FROM article AS p

            LEFT JOIN article_has_language AS px
            ON px.article_id = p.article_id
            AND px.language_id IN
            (
                SELECT language_id
                FROM language AS l
                WHERE l.code = ?
         )
            WHERE p.article_id = ?
        ";

        $sql_content = "
            SELECT*
            FROM
            (
                SELECT *
                FROM category AS a
                WHERE a.type = 'content'
         ) a
            LEFT JOIN
            (
                SELECT
                    bx.category_id,
                    cx.value

                FROM article AS p

                LEFT JOIN article_has_content AS ax
                ON ax.article_id = p.article_id

                LEFT JOIN content AS bx
                ON bx.content_id = ax.content_id

                LEFT JOIN content_has_language AS cx
                ON ax.content_id = cx.content_id
                AND cx.language_id IN
                (
                    SELECT language_id
                    FROM language AS l
                    WHERE l.code = ?
             )
                WHERE ax.article_id = ?
         ) b
            ON b.category_id = a.category_id
        ";

        $attribute = $this->PdoAdapter->fetchRow($sql_attribute, array(
            $setting->code,
            $setting->article_id
     ));

        $contents = $this->PdoAdapter->fetchRows($sql_content, array(
            $setting->code,
            $setting->article_id
     ));

        //var_dump($attribute);

        // Re-structure the content key(code) and value.
        foreach($contents as $index => $item)
        {
            // Always make the first item as 'content'.
            if($index === 0) $content['content'] = $item['value'];

            $content[$item['code']] = $item['value'];
        }

        $this->item = array_merge($attribute, $content);

        // Return $this object for chaining.
        return $this;

    }
}
