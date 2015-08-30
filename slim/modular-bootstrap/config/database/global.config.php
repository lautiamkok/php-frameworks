<?php

return array(
    'database' => array(
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=cms_master;host=localhost',
        'driver_options' => array(
            'PDO::MYSQL_ATTR_INIT_COMMAND' => 'SET NAMES \'UTF8\''
        ),
    ),

    'directory' => array(
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=cms_master;host=localhost'
    ),

    'modules' => array(
        'PageNotFound' => array(
            'name' => 'PageNotFound',
            'path' => array(
                'direction' => 'core/',
                'directory' => 'PageNotFound/'
            ),
        ),

        'Home' => array(
            'name' => 'Home',
            'path' => array(
                'direction' => 'core/',
                'directory' => 'Home/'
            ),
        ),

        'Article' => array(
            'name' => 'Article',
            'path' => array(
                'direction' => 'core/',
                'directory' => 'Article/'
            ),
        ),

        'Admin\Article' => array(
            'name' => 'Admin\Article',
            'path' => array(
                'direction' => 'core/',
                'directory' => 'Admin/Article/'
            ),
        ),
    ),
);
