<?php
/*
print_r($_SERVER["CONTENT_TYPE"]);

echo $_SERVER['REQUEST_METHOD'];

parse_str(file_get_contents("php://input"),$post_vars);
print_r($post_vars);
*/

$a = [
    0 => [
        'title' => 'e',
        'body' => 'eee'
    ],

    1 => [
        'title' => 'f',
        'body' => 'fff'
    ],

    2 => [
        'title' => 'g',
        'body' => 'ggg'
    ]
];


echo json_encode($a);
?>
