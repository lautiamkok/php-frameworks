<?php
/*
print_r($_SERVER["CONTENT_TYPE"]);

echo $_SERVER['REQUEST_METHOD'];

parse_str(file_get_contents("php://input"),$post_vars);
print_r($post_vars);
*/

$a = [
    0 => [
        'title' => 'a',
        'body' => 'aa'
    ],

    1 => [
        'title' => 'b',
        'body' => 'bb'
    ],

    2 => [
        'title' => 'c',
        'body' => 'cc'
    ]
];


echo json_encode($a);
?>
