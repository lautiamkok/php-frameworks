<?php

// @ ref: http://websec.io/2013/02/14/API-Authentication-Public-Private-Key.html
require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\Slim();

// Routes:
$app->get('/', function () {
    echo "Hello World ";
});

$app->post('/', function () use ($app) {

    // Get request headers.
    // $headers = $app->request->headers;

    // In order to access such a property in the headers use.
    // @ ref: http://help.slimframework.com/discussions/problems/5960-request-headers-problems-with-dashes
    // $xUser = $app->request->headers->get('X-User');
    // or:
    // $xUser = $app->request->headers('X-User');

    $request = $app->request();

    $publicHash  = $request->headers('X-Public');
    $contentHash = $request->headers('X-Hash');
    $privateHash  = 'e249c439ed7697df2a4b045d97d4b9b7e1854c3ff8dd668c779013653913572e';
    $content     = $request->getBody();

    // In information security, message authentication or data origin authentication is a property that
    // a message has not been modified while in transit (data integrity) and that the receiving party
    // can verify the source of the message.
    // @ ref: https://en.wikipedia.org/wiki/Message_authentication
    //
    // HMAC is Hash-based message authentication code. You should HMAC anything which you want to authenticate,
    // or in other words, anything which you want to protect against being modified.
    // @ ref: http://stackoverflow.com/questions/27833610/creating-hmac-for-php-encryption
    $hash = hash_hmac('sha256', $content, $privateHash);

    // if ($publicHash == '3441df0babc2a2dda551d7cd39fb235bc4e09cd1e4556bf261bb49188f548348'){
    if ($hash == $contentHash){
        echo "match!\n";
    } else {
        $app->halt(401);
    }
});

$app->run();
