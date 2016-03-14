<?php

return array(
    // 'PageNotFound' => array(
    //     'name' => 'PageNotFound',
    //     'directories' => array(
    //         'route.config'  => 'core/PageNotFound/',
    //         'bootstrap'  => 'core/PageNotFound/',
    //         'source'  => 'core/PageNotFound/',
    //         'theme'  => 'default/',
    //         'template'  => 'PageNotFound/'
    //     ),
    // ),

    'Home' => array(
        'name' => 'Home',
        'directories' => array(
            'route.config'  => 'core/Home/',
            'bootstrap'  => 'core/Home/',
            'source'  => 'core/Home/',
            'theme'  => 'default/',
            'template'  => 'Home/'
        ),
    ),

    'Article' => array(
        'name' => 'Article',
        'directories' => array(
            'route.config'  => 'core/Article/',
            'bootstrap'  => 'core/Article/',
            'source'  => 'core/Article/',
            'theme'  => 'default/',
            'template'  => 'Article/'
        ),
    ),

    'Admin\Article' => array(
        'name' => 'Admin\Article',
        'directories' => array(
            'route.config'  => 'core/Admin/Article/',
            'bootstrap'  => 'core/Admin/Article/',
            'source'  => 'core/Admin/Article/',
            'theme'  => 'default/',
            'template'  => 'Admin/Article/'
        ),
    ),
);
