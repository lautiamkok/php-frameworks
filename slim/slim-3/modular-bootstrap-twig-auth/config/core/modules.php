<?php
// Modules.

return [
    // 'PageNotFound' => [
    //     'name' => 'PageNotFound',
    //     'directories' => [
    //         'route'  => 'core/PageNotFound/',
    //         'result'  => 'core/PageNotFound/',
    //         'source'  => 'core/PageNotFound/',
    //         'theme'  => 'default/',
    //         'template'  => 'PageNotFound/'
    //     ],
    // ],

    //  Must load Admin route first so it won't be shadowed by Article's.
    'Admin' => [
        'name' => 'Admin',
        'directories' => [
            'route'  => 'core/Admin/',
            'result'  => 'core/Admin/',
            'source'  => 'core/Admin/',
            'theme'  => 'default/',
            'template'  => 'Admin/'
        ],
    ],

    'Home' => [
        'name' => 'Home',
        'directories' => [
            'route'  => 'core/Home/',
            'result'  => 'core/Home/',
            'source'  => 'core/Home/',
            'theme'  => 'default/',
            'template'  => 'Home/'
        ],
    ],

    'Article' => [
        'name' => 'Article',
        'directories' => [
            'route'  => 'core/Article/',
            'result'  => 'core/Article/',
            'source'  => 'core/Article/',
            'theme'  => 'default/',
            'template'  => 'Article/'
        ],
    ],

    'Admin\Login' => [
        'name' => 'Admin\Login',
        'directories' => [
            'route'  => 'core/Admin/Login/',
            'result'  => 'core/Admin/Login/',
            'source'  => 'core/Admin/Login/',
            'theme'  => 'default/',
            'template'  => 'Admin/Login/'
        ],
    ],

    'Admin\Article' => [
        'name' => 'Admin\Article',
        'directories' => [
            'route'  => 'core/Admin/Article/',
            'result'  => 'core/Admin/Article/',
            'source'  => 'core/Admin/Article/',
            'theme'  => 'default/',
            'template'  => 'Admin/Article/'
        ],
    ],

    'Admin\Book' => [
        'name' => 'Admin\Book',
        'directories' => [
            'route'  => 'core/Admin/Book/',
            'result'  => 'core/Admin/Book/',
            'source'  => 'core/Admin/Book/',
            'theme'  => 'default/',
            'template'  => 'Admin/Book/'
        ],
    ],
];
