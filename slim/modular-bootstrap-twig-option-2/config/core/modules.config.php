<?php

return array(
    'PageNotFound' => array(
        'name' => 'PageNotFound',
        'directories' => array(
            'route.config'  => 'core/PageNotFound/',
            'bootstrap'  => 'core/PageNotFound/',
            'source'  => 'core/PageNotFound/'
        ),
    ),

    'Home' => array(
        'name' => 'Home',
        'directories' => array(
            'route.config'  => 'core/Home/',
            'bootstrap'  => 'core/Home/',
            'source'  => 'core/Home/'
        ),
    ),

    'Article' => array(
        'name' => 'Article',
        'directories' => array(
            'route.config'  => 'core/Article/',
            'bootstrap'  => 'core/Article/',
            'source'  => 'core/Article/'
        ),
    ),

    'Admin\Article' => array(
        'name' => 'Admin\Article',
        'directories' => array(
            'route.config'  => 'core/Admin/Article/',
            'bootstrap'  => 'core/Admin/Article/',
            'source'  => 'core/Admin/Article/'
        ),
    ),
);
