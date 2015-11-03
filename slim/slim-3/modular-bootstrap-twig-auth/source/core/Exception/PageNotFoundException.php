<?php
/*
 * Handle 404
 */
namespace Barium\Exception;

use Exception;

class PageNotFoundException extends Exception
{
    /*
     * Set props.
     */
    protected $PdoAdapter;
    protected $message;
    
    /*
     * Construct dependency.
     */	
    public function __construct($message = null, \Barium\Adapter\PdoAdapter $PdoAdapter)
    {
        // Set dependency.
        $this->message = $message;
        $this->PdoAdapter = $PdoAdapter;
        
        $this->render();
    }
    
    /*
     *  Implement the method in CompositeStrategy.
     */
    public function render()
    {
        try 
        {
            if ($this->message !== null) 
            {
                throw new Exception($this->message);
            }
        } 
        catch (Exception $e) 
        {
            // Set the header to 404 and redirect the page to something that does not fall into the rewrite rules in the .htaccess.
            // You will get a blank page if you don't redirect. If you look at the access.log or http headers in Firebug/HTTP Watch 
            // for this blank page, you'd see a 404 return code.
            //header("HTTP/1.0 404 Not Found");
            header("HTTP/1.0 404 Not Found");
            
            // Include your layout here...
            // echo $e->getMessage();
            // 
            // Include the module.
            include APPLICATION_ROOT . 'module/core/config/public/404/index.php';
            
            // make sure the script stops
            die; 
        }
    }
}