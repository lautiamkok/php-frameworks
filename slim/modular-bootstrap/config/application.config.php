<?php

return array(
    // This should be an array of module namespaces used in the application.
    'modules' => array(
        'Application',
        'Album',
        'AlbumRest',
    ),

    // This should be an array of paths in which modules reside.
    // If a string key is provided, the listener will consider that a module
    // namespace, the value of that key the specific path to that module's
    // Module class.
    'module_paths' => array(
        './module',
        './vendor',
    ),

    'database' => array(
        'global' => '../config/database/global.config.php',
        'local' => '../config/database/local.config.php'
    ),
);
