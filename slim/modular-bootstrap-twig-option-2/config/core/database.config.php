<?php

return array(
    'driver' => 'Pdo',
    'dsn' => 'mysql:dbname=cms_master;host=localhost',
    'driver_options' => array(
        'PDO::MYSQL_ATTR_INIT_COMMAND' => 'SET NAMES \'UTF8\''
    ),
);
