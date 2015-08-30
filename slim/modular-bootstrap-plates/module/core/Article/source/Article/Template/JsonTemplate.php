<?php
/*
 * Create concrete template - html.
 */
namespace Barium\Article\Template;

use Barium\Template\AbstractTemplate;
use Barium\Util\StringManager;

class JsonTemplate extends AbstractTemplate
{
    public function render($data = [])
    {
        // Set header.
        header('Content-Type: application/json');
        
        // Inspect content type.
        //var_dump(headers_list());
        
        $array = array('article' => $data);
        
        return json_encode($array);
    }
}
