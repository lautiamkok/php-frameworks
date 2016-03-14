<?php
/*
 * Generate xml doc from supplied array.
 */
namespace Spectre\View;

use SimpleXMLElement;

class ResponseView
{
    public $xml = null;

    /*
     * The "show error message" action.
     */
    public function showErrorItems($data = [])
    {
        if(count($data) > 0)
        {
            $this->xml = new SimpleXMLElement('<xml/>');
            $response = $this->xml->addChild('response');

            foreach($data as $key => $value)
            {
                $error = $response->addChild('error');
                $error->addAttribute('elementid', $key);
                $error->addAttribute('message', $value);
            }

            Header('Content-type: text/xml');
            return $this->xml->asXML(); // you must use echo instead of return for xml.
        }
    }

    /*
     * The "show success message" action.
     */
    public function showSuccessItem($data = [])
    {
        if(count($data) > 0)
        {
            $this->xml = new SimpleXMLElement('<xml/>');
            $response = $this->xml->addChild('response');

            $success = $response->addChild('success');
            foreach($data as $key => $value)
            {
                $success->addAttribute($key, $value);
            }

            Header('Content-type: text/xml');
            return $this->xml->asXML();
         }
    }
}

