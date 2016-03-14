<?php
/*
 * Create concrete template - html.
 */
namespace Spectre\Article\Template;

//use Spectre\Strategy\TemplateStrategy;
use Spectre\Template\AbstractTemplate;
use Spectre\Util\StringManager;

class HtmlTemplate extends AbstractTemplate // implements TemplateStrategy
{
    use StringManager;

    /*
     * Set props.
     */
    protected $data = [];

    /*
     * Set html from the supplied data.
     * @param array $data
     * @return html $output
     */
    public function render($data = [])
    {
        // Store the data.
        $this->data = $data;

        // Array to vars.
        if(count($this->data) > 0) {

            // Loop the array to get the key and value.
            foreach($this->data as $key => $value){

                $$key = $value;
            }
        }

        // Turn on output buffering.
        ob_start();

        // Set header.
        header('Content-Type: text/html; charset=utf-8');

        // Inspect content type.
        //var_dump(headers_list());

        // Get the main template/ html document.
        include APPLICATION_ROOT . 'module/core/view/public/base/page/master/index.php';

        // Get current buffer contents and delete current output buffer.
        $html = ob_get_clean();

        // Return the html
        return $html;
    }
}
