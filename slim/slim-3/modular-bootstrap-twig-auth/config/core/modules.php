<?php
// Modules.

return [
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

    //  Must load Blog route first so it won't be shadowed by Article's.
    'Blog' => [
        'name' => 'Blog',
        'directories' => [
            'route'  => 'core/Blog/',
            'result'  => 'core/Blog/',
            'source'  => 'core/Blog/',
            'theme'  => 'default/',
            'template'  => 'Blog/'
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

    'Blog\Article' => [
        'name' => 'Blog\Article',
        'directories' => [
            'route'  => 'core/Blog/Article/',
            'result'  => 'core/Blog/Article/',
            'source'  => 'core/Blog/Article/',
            'theme'  => 'default/',
            'template'  => 'Blog/Article/'
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
