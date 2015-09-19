<?php

return array(

    // The home page can be set to any module,
    // for example:'local/Home/index.php','core/Article/index.php'
    // Otherwise it will fall back to the default message: 'Hello World!'
    // when no bootstrap is provided.
    'home_page' => array(
        'bootstrap' => 'core/Home/index.php'
    ),

    'database' => array(
        'global' => 'config/core/database.config.php',
        'local' => 'config/local/database.config.php'
    ),

    'modules' => array(
        'global' => 'config/core/modules.config.php',
        'local' => 'config/local/modules.config.php'
    ),

    'directories' => array(
        'global' => 'config/core/directories.config.php',
        'local' => 'config/local/directories.config.php'
    )
);
