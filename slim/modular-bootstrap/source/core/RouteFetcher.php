<?php

namespace Barium;

class RouteFetcher
{
    private $slim;

    public function __construct($slim)
    {
        $this->slim = $slim;
    }

    public function fetch()
    {
        // Set an empty file array.
        $files = [];

        // Pass the Slim object into the local scope.
        $app = $this->slim;

        // Get the application configuration.
        $applicationConfig = $app->config('application');

        // Get the global & local configurations.
        $globalConfig = require $applicationConfig['settings']['global'];
        $localConfig = require $applicationConfig['settings']['local'];

        // Get the global & local modules.
        $modulesGlobal = isset($globalConfig['modules']) ? $globalConfig['modules'] : array();
        $modulesLocal = isset($localConfig['modules']) ? $localConfig['modules'] : array();

        // Merge the configurations.
        $modules = array_merge($modulesGlobal, $modulesLocal);

        // Loop the merge array and include the classes in them.
        foreach($modules as $module)
        {
            // List all the php files inside the folder.
            $files[] = APPLICATION_ROOT . 'module/' . $module['path']['direction'] . $module['path']['directory'] . 'config/route.config.php';
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
