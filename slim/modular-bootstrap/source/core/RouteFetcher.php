<?php

class RouteFetcher
{
    private $slim;

    public function __construct($slim)
    {
        $this->slim = $slim;
    }

    public function fetch($directories)
    {
        $app = $this->slim;
        $files = [];

        // Loop the merge array and include the classes in them.
        foreach($directories as $directory)
        {
            // List all the php files inside the folder.
            $files[] = APPLICATION_ROOT . 'module/' . $directory . 'config/route.config.php';
        }

        // Loop and include the files.
        foreach($files as $file)
        {
            require $file;
        }

        // // Loop the merge array and include the classes in them.
        // foreach($directories as $directory)
        // {
        //     // List all the php files inside the folder.
        //     $files[] = glob(WEBSITE_DOCROOT . 'module/' . $directory . 'config/'. '*.php' );
        // }

        // // Flatten the multiple array.
        // $arrayFlatten = call_user_func_array('array_merge', $files);

        // // Loop and include the files.
        // foreach($arrayFlatten as $file)
        // {
        //     require $file;
        // }
    }
}
