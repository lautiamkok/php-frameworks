<?php
/*
 * Get a Template object.
 */
namespace Barium\Article\Factory;

class TemplateFactory
{   
    //  Receive request data and create an object.
    public function getTemplate($format) 
    {
        // Construct our class name and check its existence.
        $class =  'Barium\Article\Template\\'. ucfirst($format) . 'Template';
        
        if(class_exists($class)) {
            
            // Return a new Template object.
            return new $class();
        }
        
        // Otherwise we fail.
        throw new \Exception('Unsupported format');
    }
}
